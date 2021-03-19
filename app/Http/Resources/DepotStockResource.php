<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Carbon;

class DepotStockResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'buy_price' => $request->buyPrice,
            'buy_date' => Carbon::createFromFormat('m/d/Y', $request->buyDate)->format('Y-m-d'),
            'buy_currency' => $request->buyCurrency,
            'quantity' => $request->quantity
        ];
    }
}
