<?php

namespace App\Services\TariffsComparison\Calculators\Contracts;

use App\Services\TariffsComparison\Data\ProductData;

interface TariffCalculation
{
    public function calculate(int $consumption, ProductData $product) : int;
}
