<?php

namespace App\Services\TariffsComparison\Calculators;

use App\Services\TariffsComparison\Calculators\Contracts\TariffCalculation;
use App\Services\TariffsComparison\Data\ProductData;

class PackagedTariffCalculator implements TariffCalculation
{
    public function calculate(int $consumption, ProductData $product): int
    {
        if ($consumption < $product->includedKwh) {
            return $product->baseCost;
        }

        return $product->baseCost + (($consumption - $product->includedKwh) * ($product->additionalKwhCost / 100));
    }

}
