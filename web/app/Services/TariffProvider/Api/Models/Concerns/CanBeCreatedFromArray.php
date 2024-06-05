<?php

namespace App\Services\TariffProvider\Api\Models\Concerns;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;

trait CanBeCreatedFromArray
{
    protected static function keys() : array
    {
        return array_keys(get_class_vars(self::class));
    }

    public static function createFromArray(array $data, bool $ignoreUndefinedKey = true) : static
    {
        $args = $ignoreUndefinedKey ? Arr::only($data, self::keys()) : $data;

        return new self(...$args);
    }
}
