<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Depot extends Model
{
    protected $fillable = [
        'depot_title',
        'depot_currency'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function stocks()
    {
        return $this->belongsToMany(Stock::class, 'depot_stock')
            ->withPivot('quantity', 'buy_price', 'buy_date', 'buy_currency');
    }
}
