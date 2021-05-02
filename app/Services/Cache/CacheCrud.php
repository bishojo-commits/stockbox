<?php

namespace App\Services\Cache;

use App\Models\Stock;

interface CacheCrud
{
    public function add(Stock $stock, object $result);
}
