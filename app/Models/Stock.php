<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    protected $fillable = [
        'name',
        'wkn_number',
        'ticker_symbol'
    ];

    public function depots()
    {
        return $this->belongsToMany(Depot::class, 'depot_stock')
            ->withPivot('quantity', 'buy_price', 'buy_date', 'buy_currency');
    }
}
