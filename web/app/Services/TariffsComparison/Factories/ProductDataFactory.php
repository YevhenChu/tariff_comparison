<?php

namespace App\Services\TariffsComparison\Factories;

use App\Services\TariffProvider\Api\Models\Product;
use App\Services\TariffsComparison\Data\ProductData;

final class ProductDataFactory
{
    public function makeFromProduct(Product $product) : ProductData
    {
        return new ProductData(
            name: $product->name,
            type: $product->type,
            baseCost: $product->baseCost,
            includedKwh: $product->includedKwh,
            additionalKwhCost: $product->additionalKwhCost,
        );
    }
}
