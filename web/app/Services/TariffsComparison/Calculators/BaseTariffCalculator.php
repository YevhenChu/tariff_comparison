<?php

namespace App\Services\TariffsComparison\Calculators;

use App\Services\TariffsComparison\Calculators\Contracts\TariffCalculation;
use App\Services\TariffsComparison\Data\ProductData;

class BaseTariffCalculator implements TariffCalculation
{
    public function calculate(int $consumption, ProductData $product): int
    {
        return ($product->baseCost * 12) + ($consumption * ($product->additionalKwhCost / 100));
    }
}
