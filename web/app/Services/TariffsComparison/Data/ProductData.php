<?php

namespace App\Services\TariffsComparison\Data;

final class ProductData
{
    public function __construct(
        public readonly string $name,
        public readonly int $type,
        public readonly ?int $baseCost,
        public readonly ?int $includedKwh,
        public readonly ?int $additionalKwhCost,
    ) {
    }
}
