<?php

namespace App\Services\TariffProvider\Api\Resources\Requests;

use App\Services\TariffProvider\Api\Resources\Contracts\Request;

/**
 * @codeCoverageIgnore
 */
abstract class JsonRequest implements Request
{
    abstract public function endpoint() : string;

    abstract public function method() : string;

    public function format() : string
    {
        return 'json';
    }

    public function headers() : array
    {
        return [
            'Accept'       => 'application/json',
            'Content-Type' => 'application/json',
        ];
    }

    public function queryParams() : array
    {
        return [];
    }

    public function data() : array
    {
        return [];
    }

    public function toArray() : array
    {
        return [
            'endpoint'    => $this->endpoint(),
            'format'      => $this->format(),
            'headers'     => $this->headers(),
            'queryParams' => $this->queryParams(),
            'data'        => $this->data(),
        ];
    }
}
