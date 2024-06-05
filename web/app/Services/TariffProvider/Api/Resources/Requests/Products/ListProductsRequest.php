<?php

namespace App\Services\TariffProvider\Api\Resources\Requests\Products;

use App\Services\TariffProvider\Api\Resources\Requests\JsonRequest;

class ListProductsRequest extends JsonRequest
{
    public function __construct(protected readonly string $baseUrl)
    {
    }

    public function endpoint() : string
    {
        return sprintf('%s/products/list', $this->baseUrl);
    }

    public function queryParams() : array
    {
        return [];
    }

    public function method() : string
    {
        return 'get';
    }

    public function headers() : array
    {
        return parent::headers();
    }
}
