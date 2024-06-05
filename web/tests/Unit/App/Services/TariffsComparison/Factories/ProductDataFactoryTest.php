<?php

namespace Tests\Unit\App\Services\TariffsComparison\Factories;

use Tests\TestCase;
use App\Services\TariffProvider\Api\Models\Product;
use App\Services\TariffsComparison\Data\ProductData;
use App\Services\TariffsComparison\Factories\ProductDataFactory;

class ProductDataFactoryTest extends TestCase
{
    public function test_returns_a_product_data()
    {
        $product = new Product(
            name: 'company name',
            type: 1,
            baseCost: 800,
            includedKwh: 0,
            additionalKwhCost: 22,
        );
        $productDataFactory = (new ProductDataFactory())->makeFromProduct($product);
        $this->assertInstanceOf(ProductData::class, $productDataFactory);
    }
}
