<?php

namespace App\Services\TariffProvider\Api;

use Illuminate\Support\Arr;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\RequestException;
use Illuminate\Http\Client\ConnectionException;
use App\Services\TariffProvider\Api\Resources\Contracts\Request;
use App\Services\TariffProvider\Api\Exceptions\TariffProviderRequestError;

class RequestHandler
{
    public function send(Request $request) : Response
    {
        try {
            $response = Http::throw()
                ->withQueryParameters($request->queryParams())
                ->withHeaders($request->headers())
                ->send(
                    method: $request->method(),
                    url: $request->endpoint(),
                    options: [$request->format() => $request->data()],
                );
        } catch (RequestException $requestException) {
            $this->handleRequestException($requestException);
        }
         catch (ConnectionException $connectionException) {
             $this->handleConnectionException($connectionException);
         }

        return $response;
    }

    /**
     * @throws \Exception
     */
    protected function handleRequestException(RequestException $requestException) : never
    {
        $response = $requestException->response;

        $data = $response->json();

        $message = Arr::get($data, 'error');

        if ($message === null) {
            $message = $response->clientError() ? 'Client error' : 'Server error';
        }

        throw new TariffProviderRequestError(
            message: '[Trariff Provider] ' . (string) $message,
            previous: $requestException,
        );
    }

    /**
     * @throws \Exception
     */
    protected function handleConnectionException(ConnectionException $connectionException) : never
    {
        $message = $connectionException->getMessage();

        throw new TariffProviderRequestError(
            message: '[Trariff Provider] ' . $message,
            previous: $connectionException,
        );
    }
}
