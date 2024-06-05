<?php

namespace Tests\Unit\App\Services\TariffProvider\Api\Factories;

use App\Services\TariffProvider\Api\Models\Product;
use Tests\TestCase;
use Illuminate\Http\Client\Response;
use GuzzleHttp\Psr7\Response as Psr7Response;
use App\Services\TariffProvider\Api\Factories\ProductsFactory;

class ProductsFactoryTest extends TestCase
{
    private array $products;

    public function setUp() : void
    {
        parent::setUp();

        $data = file_get_contents(base_path('tests/Support/TariffsComparison/products.json'));
        $this->products = json_decode($data, true)['data'];

    }

    public function test_returns_a_collection_of_products()
    {
        $itemsCount = count($this->products);
        $response = new Response(new Psr7Response(body: json_encode($this->products)));
        $collection = ProductsFactory::make()->fromResponse($response);

        $this->assertCount($itemsCount, $collection);
        $collection->each(fn ($item) => $this->assertInstanceOf(Product::class, $item));
    }

    public function test_returns_an_empty_collection_of_products_when_response_does_not_have_data()
    {
        $response = new Response(new Psr7Response(body: json_encode([])));
        $collection = ProductsFactory::make()->fromResponse($response);
        $this->assertCount(0, $collection);
    }

    public function test_returns_an_empty_collection_of_products_when_response_data_is_not_an_array()
    {
        $response = new Response(new Psr7Response(body: json_encode('test')));
        $collection = ProductsFactory::make()->fromResponse($response);
        $this->assertCount(0, $collection);
    }
}
