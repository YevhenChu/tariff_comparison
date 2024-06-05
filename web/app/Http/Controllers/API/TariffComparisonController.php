<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\TariffComparisonRequest;
use App\Http\Resources\TariffComparisonResource;
use App\Services\TariffProvider\Api\Models\Product;
use App\Services\TariffsComparison\TariffsComparisonService;
use App\Services\TariffProvider\Api\TariffProviderApiService;
use App\Services\TariffsComparison\Factories\ProductDataFactory;
use App\Services\TariffProvider\Api\Exceptions\TariffProviderRequestError;

class TariffComparisonController extends BaseController
{
    public function __construct(
        protected readonly TariffProviderApiService $tariffProviderApiService,
        protected readonly TariffsComparisonService $tariffsComparisonService,
        protected readonly ProductDataFactory $productDataFactory,
    ) {
    }

    public function __invoke(TariffComparisonRequest $request)
    {
        try {
            $products = $this->tariffProviderApiService->products()->listProducts();
        } catch(TariffProviderRequestError $e) {
            return $this->sendError(
                'The tariffs cannot be compared. An internal error has occurred. Try again later.',
                [],
                500
            );
        }

        $annualCosts = $this->tariffsComparisonService->compare(
            $request->post('consumption'),
            $products->map(fn (Product $product) => $this->productDataFactory->makeFromProduct($product)),
            config('tariff_comparison.calculators')
        );

        return $this->sendResponse(TariffComparisonResource::collection($annualCosts), '');
    }
}
