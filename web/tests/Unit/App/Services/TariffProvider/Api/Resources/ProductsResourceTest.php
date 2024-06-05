<?php

namespace Tests\Unit\App\Services\TariffProvider\Api\Resources;

use Tests\TestCase;
use Illuminate\Support\Facades\Http;
use App\Services\TariffProvider\Api\Resources\ProductsResource;

class ProductsResourceTest extends TestCase
{
    private array $products;

    private ProductsResource $resource;
    public function setUp() : void
    {
        parent::setUp();

        $data = file_get_contents(base_path('tests/Support/TariffsComparison/products.json'));
        $this->products = json_decode($data, true)['data'];

        $this->resource = new ProductsResource(baseUrl: config('tariff_comparison.baseUrl'));
    }

    public function test_returns_the_list_of_products()
    {
        Http::fake([config('tariff_comparison.baseUrl') . '/*' => Http::response(json_encode($this->products))]);
        $collection = $this->resource->listProducts();

        Http::assertSentCount(1);
        $this->assertCount(count($this->products), $collection);
    }
}
