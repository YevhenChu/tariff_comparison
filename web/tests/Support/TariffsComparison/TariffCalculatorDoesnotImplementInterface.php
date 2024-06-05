<?php

namespace Tests\Support\TariffsComparison;

use App\Services\TariffsComparison\Data\ProductData;

class TariffCalculatorDoesnotImplementInterface
{
    public function calculate(int $consumption, ProductData $product): int
    {
        return 100;
    }
}
