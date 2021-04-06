<?php

namespace Tests\Unit\Transformers;

use App\Models\Depot;
use App\Models\Stock;
use App\Models\User;
use App\Traits\DateFormatter;
use App\Transformers\DepotTotalTransformer;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class DepotTotalTransformerTest extends TestCase
{
    use DateFormatter;
    use WithFaker;

    public function testTransformerCalculatesDepotTotal()
    {
        $user = factory(User::class)->create();
        $depot = factory(Depot::class)->create([
            'user_id' => $user->id
        ]);

        $stock = $this->createStock('TSLA');
        $stockTwo = $this->createStock('IJ8');

        $depot->stocks()->attach($stock, $this->createPivotData(400.00, 6));
        $depot->stocks()->attach($stockTwo, $this->createPivotData(6.00, 10));

        $result[0] = $this->createResultData("TSLA", 500.00);
        $result[1] = $this->createResultData("IJ8", 7.00);

        $transformer = new DepotTotalTransformer($depot->stocks);
        $assertionResult = $transformer->transform($result);

        $this->assertEquals(3070.00, $assertionResult['depotTotal']);
    }

    public function testTransformerCalculatesDepotTotalEmptyResult()
    {
        $user = factory(User::class)->create();
        $depot = factory(Depot::class)->create([
            'user_id' => $user->id
        ]);

        $result = [];

        $transformer = new DepotTotalTransformer($depot->stocks);
        $assertionResult = $transformer->transform($result);

        $this->assertEquals(0.00, $assertionResult['depotTotal']);
    }

    private function createStock(string $tickerSymbol)
    {
        return factory(Stock::class)->create(
            [
                'name' => $this->faker->name,
                'wkn_number' => $this->faker->randomNumber(6),
                'ticker_symbol' => $tickerSymbol
            ]
        );
    }

    private function createResultData(string $tickerSymbol, float $marketPrice)
    {
        return json_decode(json_encode(
            [
                "meta" => ["symbol" => $tickerSymbol],
                "price" => [
                    "regularMarketOpen" => ["raw" => $marketPrice]
                ]
            ]
        ));
    }

    private function createPivotData(float $buyPrice, int $quantity)
    {
        return [
            'buy_price' => $buyPrice,
            'buy_currency' => 'Euro',
            'buy_date' => $this->formatDate('05/06/2020'),
            'quantity' => $quantity
        ];
    }
}
