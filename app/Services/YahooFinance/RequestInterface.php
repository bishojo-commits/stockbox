<?php

namespace App\Services\YahooFinance;

use App\Models\Stock;

interface RequestInterface
{
    public function callApi(Stock $stock);
}
