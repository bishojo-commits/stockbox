<?php

namespace Tests\Helpers;

use App\Models\Stock;
use App\Traits\DateFormatter;

trait TestDataCreator
{
    use DateFormatter;

    protected function createStock(string $tickerSymbol)
    {
        return factory(Stock::class)->create(
            [
                'name' => $this->faker->name,
                'wkn_number' => $this->faker->randomNumber(6),
                'ticker_symbol' => $tickerSymbol
            ]
        );
    }

    protected function createResultData(string $tickerSymbol, float $marketPrice)
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

    protected function createStockPivotData(float $buyPrice, int $quantity)
    {
        return [
            'buy_price' => $buyPrice,
            'buy_currency' => 'Euro',
            'buy_date' => $this->formatDate('05/06/2020'),
            'quantity' => $quantity
        ];
    }
}
