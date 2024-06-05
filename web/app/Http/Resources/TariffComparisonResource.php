<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TariffComparisonResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request $request
     * @return array
     */
    public function toArray(Request $request): array
    {
        return [
            'name'      => $this['name'],
            'annualCost'  => $this['annualCost'],
        ];
    }
}
