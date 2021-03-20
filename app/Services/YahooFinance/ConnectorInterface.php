<?php

namespace App\Services\YahooFinance;

use App\Models\Stock;

interface ConnectorInterface
{
    public function callApi(Stock $stock);
}
