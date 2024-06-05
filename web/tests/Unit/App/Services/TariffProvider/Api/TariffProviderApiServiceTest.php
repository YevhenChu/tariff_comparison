<?php

namespace Tests\Unit\App\Services\TariffProvider\Api;

use App\Services\TariffProvider\Api\Resources\ProductsResource;
use Tests\TestCase;
use App\Services\TariffProvider\Api\TariffProviderApiService;

class TariffProviderApiServiceTest extends TestCase
{
    public function test_returns_products_resource()
    {
        $instance = app(TariffProviderApiService::class, ['baseUrl' => 'http://test.url']);
        $this->assertInstanceOf(ProductsResource::class, $instance->products());
    }
}
