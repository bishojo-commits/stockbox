<?php

namespace App\Traits;

use App\Models\Depot;
use App\Models\Stock;
use Illuminate\Http\Request;

trait DataComposer
{
    use DateFormatter;

    protected function pivot(Request $request)
    {
        return [
            'buy_price' => $request->buy_price,
            'buy_date' => $this->formatDate($request->buy_date),
            'buy_currency' => $request->buy_currency,
            'quantity' => $request->quantity
        ];
    }

    protected function model(Request $request)
    {
        return $request->only(['name', 'wkn_number', 'ticker_symbol']);
    }
}
