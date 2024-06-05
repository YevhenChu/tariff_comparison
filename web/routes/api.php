<?php

use App\Http\Controllers\API\TariffComparisonController;
use Illuminate\Support\Facades\Route;

//Route::get('/user', function (Request $request) {
//    return $request->user();
//})->middleware('auth:sanctum');


Route::post('/tariffs/comparison', TariffComparisonController::class);

/**
 * Mocking of Tariff Provider's products
 */
Route::get('/products/list', function () {
    return [
        [
            "name" => "Product A",
            "type" => 1,
            "baseCost" => 5,
            "additionalKwhCost" => 22,
        ],
        [
            "name" => "Product B",
            "type" => 2,
            "includedKwh" => 4000,
            "baseCost" => 800,
             "additionalKwhCost" => 30
        ],
        [
            "name" => "Product C",
            "type" => 2,
            "includedKwh" => 5000,
            "baseCost" => 1000,
            "additionalKwhCost" => 32
        ],
    ];
});
