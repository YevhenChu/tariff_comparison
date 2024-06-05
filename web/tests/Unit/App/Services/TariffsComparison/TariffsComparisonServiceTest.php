<?php

namespace Tests\Unit\App\Services\TariffsComparison;

use Tests\TestCase;
use Illuminate\Support\LazyCollection;
use PHPUnit\Framework\Attributes\DataProvider;
use App\Services\TariffsComparison\Data\ProductData;
use App\Services\TariffsComparison\TariffsComparisonService;
use App\Services\TariffsComparison\Calculators\BaseTariffCalculator;
use App\Services\TariffsComparison\Exceptions\TariffsComparisonError;
use App\Services\TariffsComparison\Calculators\PackagedTariffCalculator;

class TariffsComparisonServiceTest extends TestCase
{
    private array $products;

    public function setUp() : void
    {
        parent::setUp();

        $data = file_get_contents(base_path('tests/Support/TariffsComparison/products.json'));
        $this->products = json_decode($data, true)['data'];
    }

    public function test_throws_exception_class_does_not_exist()
    {
        $this->expectException(TariffsComparisonError::class);
        $products = $this->prepareProductsData();
        $calculators = $this->prepareCalculators();
        $calculators['1'] = 'App\Services\TariffsComparison\Calculators\IncorrectClassName';

        (new TariffsComparisonService())->compare(3500, $products, $calculators)->all();
    }

    public function test_throws_exception_type_of_product_calculator_does_not_exist()
    {
        $this->products[0]['type'] = 3;
        $this->expectException(TariffsComparisonError::class);
        $products = $this->prepareProductsData();
        $calculators = $this->prepareCalculators();

        (new TariffsComparisonService())->compare(3500, $products, $calculators)->all();
    }

    public function test_throws_exception_class_does_not_implement_interface()
    {
        $this->expectException(TariffsComparisonError::class);
        $products = $this->prepareProductsData();
        $calculators = $this->prepareCalculators();
        $calculators['1'] = 'Tests\Support\TariffsComparison\TariffCalculatorDoesnotImplementInterface';

        (new TariffsComparisonService())->compare(3500, $products, $calculators)->all();
    }

    #[DataProvider('listConsumptionAndExpectedResult')]
    public function test_returns_a_list_of_calculated_annual_tariffs(int $consumption, array $expected)
    {
        $products = $this->prepareProductsData();
        $calculators = $this->prepareCalculators();

        $service = new TariffsComparisonService();
        $annualCosts = $service->compare($consumption, $products, $calculators);

        $this->assertInstanceOf(LazyCollection::class, $annualCosts);
        $annualCosts->values()->each(function ($item, $index) use ($expected) {
            $this->assertEquals($expected[$index], $item['annualCost']);
        });
    }

    public static function listConsumptionAndExpectedResult() : array
    {
        return [
            'consumption: 3500 kWh/year' => [
                'consumption' => 3500,
                'expected' => [800, 830, 1000]
             ],
            'consumption: 4500 kWh/year' => [
                'consumption' => 4500,
                'expected' => [950, 1000, 1050]
             ],
        ];
    }

    protected function prepareCalculators() : array
    {
        return [
            '1' => BaseTariffCalculator::class,
            '2' => PackagedTariffCalculator::class,
        ];
    }

    protected function prepareProductsData() : LazyCollection
    {
        return new LazyCollection(function () {
            $productsData = $this->products;

            if (! is_array($productsData)) {
                return;
            }

            foreach ($productsData as $product) {
                yield new ProductData(
                    name: $product['name'],
                    type: $product['type'],
                    baseCost: $product['baseCost'] ?? 0,
                    includedKwh: $product['includedKwh'] ?? 0,
                    additionalKwhCost: $product['additionalKwhCost'] ?? 0,
                );
            }
        });
    }
}
