<?php

namespace Tests\Unit\App\Services\TariffsComparison\Calculators;

use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\DataProvider;
use App\Services\TariffsComparison\Data\ProductData;
use App\Services\TariffsComparison\Calculators\PackagedTariffCalculator;

class PackagedTariffCalculatorTest extends TestCase
{
    #[DataProvider('listProductsData')]
    public function test_returns_calculated_tariff(int $consumption, array $productData, int $expectedResult): void
    {
        $product = new ProductData(
            name: $productData['name'],
            type: $productData['type'],
            baseCost: $productData['baseCost'],
            includedKwh: $productData['includedKwh'],
            additionalKwhCost: $productData['additionalKwhCost'],
        );

        $this->assertEquals($expectedResult, (new PackagedTariffCalculator())->calculate($consumption, $product));
    }

    public static function listProductsData() : array
    {
        return [
            'Packaged tariff (Consumption: 3500 kWh/year)' => [
                'consumption' => 3500,
                'productData' => [
                    'name' => 'packed tariff 3500',
                    'type' => 2,
                    'baseCost' => 800,
                    'includedKwh' => 4000,
                    'additionalKwhCost' => 30,
                ],
                'expectedResult' => 800,
            ],
            'Packaged tariff (Consumption: 4500 kWh/year)' => [
                'consumption' => 4500,
                'productData' => [
                    'name' => 'packed tariff 4500',
                    'type' => 1,
                    'baseCost' => 800,
                    'includedKwh' => 4000,
                    'additionalKwhCost' => 30,
                ],
                'expectedResult' => 950,
            ],
        ];
    }
}
