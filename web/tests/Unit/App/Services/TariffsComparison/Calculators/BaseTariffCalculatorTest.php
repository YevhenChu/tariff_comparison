<?php

namespace Tests\Unit\App\Services\TariffsComparison\Calculators;

use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\DataProvider;
use App\Services\TariffsComparison\Data\ProductData;
use App\Services\TariffsComparison\Calculators\BaseTariffCalculator;

class BaseTariffCalculatorTest extends TestCase
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

        $this->assertEquals($expectedResult, (new BaseTariffCalculator())->calculate($consumption, $product));
    }

    public static function listProductsData() : array
    {
        return [
            'base tariff (Consumption: 3500 kWh/year)' => [
                'consumption' => 3500,
                'productData' => [
                    'name' => 'base tariff 3500',
                    'type' => 1,
                    'baseCost' => 5,
                    'includedKwh' => 0,
                    'additionalKwhCost' => 22,
                ],
                'expectedResult' => 830,
            ],
            'base tariff (Consumption: 4500 kWh/year)' => [
                'consumption' => 4500,
                'productData' => [
                    'name' => 'base tariff 4500',
                    'type' => 1,
                    'baseCost' => 5,
                    'includedKwh' => 0,
                    'additionalKwhCost' => 22,
                ],
                'expectedResult' => 1050,
            ],
        ];
    }
}
