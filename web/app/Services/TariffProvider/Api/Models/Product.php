<?php

namespace App\Services\TariffProvider\Api\Models;

use App\Services\TariffProvider\Api\Models\Concerns\CanBeCreatedFromArray;

final class Product
{
    use CanBeCreatedFromArray;

    public function __construct(
        public readonly string $name,
        public readonly int $type,
        public readonly ?int $baseCost,
        public readonly ?int $includedKwh,
        public readonly ?int $additionalKwhCost,
    ) {
    }
}
