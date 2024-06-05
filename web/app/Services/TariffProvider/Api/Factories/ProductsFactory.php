<?php

namespace App\Services\TariffProvider\Api\Factories;

use Illuminate\Http\Client\Response;
use Illuminate\Support\LazyCollection;
use App\Services\TariffProvider\Api\Models\Product;

final class ProductsFactory
{
    public static function make() : static
    {
        return new self;
    }

    public function fromResponse(Response $response) : LazyCollection
    {
        return new LazyCollection(function () use ($response) {
            $products = $response->json();

            if (! is_array($products)) {
                return;
            }

            foreach ($products as $product) {
                yield $this->fromArray($product);
            }
        });
    }

    /**
     * @throws \Exception
     */
    public function fromArray(array $item) : Product
    {
        return Product::createFromArray([
            'name'              => $item['name'] ?? 'Unknown company name',
            'type'              => $item['type'] ?? null,
            'baseCost'          => $item['baseCost'] ?? 0.00,
            'includedKwh'       => $item['includedKwh'] ?? 0.00,
            'additionalKwhCost' => $item['additionalKwhCost'] ?? 0.00,
        ]);
    }
}
