<?php

namespace App\Services\Cache;

use App\Data\CacheKeys;
use App\Models\Stock;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;

class CacheHandler implements CacheCrud
{
    public function add(Stock $stock, object $result)
    {
        Cache::add(
            $this->getKey($stock),
            $result,
            Carbon::now()->addMinutes(10)
        );
    }

    protected function getKey(Stock $stock)
    {
        return CacheKeys::FINANCIAL . $stock->ticker_symbol;
    }
}
