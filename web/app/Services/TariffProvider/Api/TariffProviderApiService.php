<?php

namespace App\Services\TariffProvider\Api;

use App\Services\TariffProvider\Api\Resources\ProductsResource;

class TariffProviderApiService
{
    public function __construct(protected string $baseUrl)
    {
    }

    public function products() : ProductsResource
    {
        return new ProductsResource($this->baseUrl);
    }
}
