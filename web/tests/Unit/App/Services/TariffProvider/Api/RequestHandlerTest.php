<?php

namespace Tests\Unit\App\Services\TariffProvider\Api;

use GuzzleHttp\Psr7\Response as Psr7Response;
use Illuminate\Http\Client\Response;
use Tests\TestCase;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Http;
use GuzzleHttp\Promise\RejectedPromise;
use GuzzleHttp\Exception\ConnectException;
use GuzzleHttp\Psr7\Request as Psr7Request;
use Illuminate\Http\Client\RequestException;
use Illuminate\Http\Client\Request as HttpRequest;
use App\Services\TariffProvider\Api\RequestHandler;
use App\Services\TariffProvider\Api\Resources\Contracts\Request;
use App\Services\TariffProvider\Api\Exceptions\TariffProviderRequestError;

class RequestHandlerTest extends TestCase
{
    public function setUp() : void
    {
        parent::setUp();

        Http::preventStrayRequests();
    }

    public function test_send_request()
    {
        $body = '{"status":1, error: null}';

        Http::fake([
            config('tariff_comparison.baseUrl') . '/*' => Http::response($body),
        ]);

        $handler = new RequestHandler();
        $mockedRequest = $this->getRequest();
        $response = $handler->send($mockedRequest);

        $this->assertEquals($body, $response->body());

        Http::assertSentCount(1);

        Http::assertSent(function (HttpRequest $request) use ($mockedRequest) {
            return Str::startsWith($request->url(), $mockedRequest->endpoint())
                && strlen($request->url()) === strlen($mockedRequest->endpoint())
                && strtolower($request->method()) === $mockedRequest->method()
                && $request->body() === json_encode($mockedRequest->data());
        });
    }

    public function test_connect_exception_was_thrown_by_http_client()
    {
        $this->expectException(TariffProviderRequestError::class);
        $this->expectExceptionMessage('[Trariff Provider] Connection error');

        $guzzleRequest = new Psr7Request('get', config('tariff_comparison.baseUrl'));

        Http::fake([
            config('tariff_comparison.baseUrl') . '/*' => fn ($request) => new RejectedPromise(
                new ConnectException('Connection error', $guzzleRequest)
            ),
        ]);

        $handler = new RequestHandler();
        $mockedRequest = $this->getRequest();
        $response = $handler->send($mockedRequest);
    }

    public function test_request_exception_was_thrown_by_http_client()
    {
        $this->expectException(TariffProviderRequestError::class);
        $this->expectExceptionMessage('[Trariff Provider] Server error');

        $response = new Response(new Psr7Response(body: json_encode([])));

        Http::fake([
            config('tariff_comparison.baseUrl') . '/*' => fn ($request) => new RejectedPromise(
                new RequestException($response)
            ),
        ]);

        $handler = new RequestHandler();
        $mockedRequest = $this->getRequest();
        $response = $handler->send($mockedRequest);
    }

    private function getRequest() : Request
    {
        return new class () implements Request {
            public function endpoint() : string
            {
                return sprintf('%s/products/list', config('tariff_comparison.baseUrl'));
            }

            public function method() : string
            {
                return 'get';
            }

            public function format() : string
            {
                return 'json';
            }

            public function headers() : array
            {
                return [];
            }

            public function queryParams() : array
            {
                return [];
            }

            public function data() : array
            {
                return ['data' => 'value'];
            }

            public function toArray() : array
            {
                return [
                    'endpoint'    => $this->endpoint(),
                    'format'      => $this->format(),
                    'headers'     => $this->headers(),
                    'queryParams' => $this->queryParams(),
                    'data'        => $this->data(),
                ];
            }
        };
    }
}
