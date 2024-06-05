<?php

namespace Tests\Unit\App\Services\TariffProvider\Api\Resources\Requests\Products;

use Tests\TestCase;
use App\Services\TariffProvider\Api\Resources\Requests\Products\ListProductsRequest;

class ListProductsRequestTest extends TestCase
{
    private string $baseUrl;

    private ListProductsRequest $request;

    public function setUp() : void
    {
        $this->baseUrl = 'http://test.url';

        $this->request = app(
            ListProductsRequest::class,
            ['baseUrl' => $this->baseUrl]
        );

    }

    public function test_returns_correct_url()
    {
        $this->assertEquals(sprintf('%s/products/list', $this->baseUrl), $this->request->endpoint());
    }
}
