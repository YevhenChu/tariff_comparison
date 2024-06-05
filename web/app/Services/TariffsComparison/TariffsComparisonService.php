<?php

namespace App\Services\TariffsComparison;

use Illuminate\Support\LazyCollection;
use App\Services\TariffsComparison\Data\ProductData;
use App\Services\TariffsComparison\Exceptions\TariffsComparisonError;
use App\Services\TariffsComparison\Calculators\Contracts\TariffCalculation;

class TariffsComparisonService
{
    public function compare(int $consumption, LazyCollection $products, array $calculators) : LazyCollection
    {
        return $products->map(function (ProductData $product) use ($consumption, $calculators) {
            $this->checkThatTypeOfCalculatorExists($product, $calculators);
            $this->checkThatClassExists($calculators[$product->type]);

            $calculator = new $calculators[$product->type];

            $this->checkThatClassImplementInterface($calculator, $calculators[$product->type]);

            return [
                'name' => $product->name,
                'annualCost' => $calculator->calculate($consumption, $product)
            ];
        })
        ->sortBy('annualCost');
    }

    /**
     * @throws App\Services\TariffsComparison\Exceptions\TariffsComparisonError
     */
    protected function checkThatTypeOfCalculatorExists(ProductData $product, array $calculators) : void
    {
        if (! isset($calculators[$product->type])) {
            throw new TariffsComparisonError(sprintf(
                'Current type of product calculator does not exist. [name: %s, type: %s]',
                $product->name,
                $product->type
            ));
        }
    }

    /**
     * @throws App\Services\TariffsComparison\Exceptions\TariffsComparisonError
     */
    protected function checkThatClassExists(string $classPath) : void
    {
        if (!class_exists($classPath)) {
            throw new TariffsComparisonError(sprintf('Class (%s) does not exist.', $classPath));
        }
    }

    /**
     * @throws App\Services\TariffsComparison\Exceptions\TariffsComparisonError
     */
    protected function checkThatClassImplementInterface($calculator, string $classPath) : void
    {
        if (!$calculator instanceof TariffCalculation) {
            throw new TariffsComparisonError(sprintf(
                'Class "%s" does not implement the TariffCalculation interface',
                $classPath
            ));
        }
    }
}
