<?php

namespace App\Services\TariffProvider\Api\Resources\Contracts;

use App\Support\Arrayable;

interface Request extends Arrayable
{
    public function endpoint() : string;

    public function method() : string;

    public function format() : string;

    public function headers() : array;

    public function queryParams() : array;

    public function data() : array;
}
