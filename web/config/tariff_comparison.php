<?php

use App\Services\TariffsComparison\Calculators\BaseTariffCalculator;
use App\Services\TariffsComparison\Calculators\PackagedTariffCalculator;

return [
    'baseUrl' => env('TARIFF_PROVIDER_BASE_URL'),

    'calculators' => [
        '1' => BaseTariffCalculator::class,
        '2' => PackagedTariffCalculator::class,
    ],
];
