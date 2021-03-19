<?php

namespace App\Traits;

use Illuminate\Support\Carbon;
use DateTime;

trait DateFormatter
{
    protected function formatDate(string $date)
    {
        return Carbon::createFromFormat('m/d/Y', $date)->format('Y-m-d');
    }

    protected function formatTimestamp(int $timestamp)
    {
        $date = new DateTime();
        $date->setTimestamp($timestamp);
        return $date->format('Y-m-d');
    }
}
