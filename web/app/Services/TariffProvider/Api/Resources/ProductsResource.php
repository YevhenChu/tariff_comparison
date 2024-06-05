<?php

namespace App\Services\TariffProvider\Api\Resources;

use Illuminate\Support\LazyCollection;
use App\Services\TariffProvider\Api\RequestHandler;
use App\Services\TariffProvider\Api\Factories\ProductsFactory;
use App\Services\TariffProvider\Api\Resources\Requests\Products\ListProductsRequest;

class ProductsResource
{
    public function __construct(protected readonly string $baseUrl)
    {
    }

    public function listProducts() : LazyCollection
    {
        $handler = new RequestHandler();
        $response = $handler->send(
            new ListProductsRequest($this->baseUrl)
        );

        return ProductsFactory::make()->fromResponse($response);
    }
}
