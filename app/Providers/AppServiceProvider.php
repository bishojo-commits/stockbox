<?php

namespace App\Providers;

use App\Http\Controllers\YahooFinance\StockHistoricalController;
use App\Services\YahooFinance\HistoricalRequest;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('App\Services\YahooFinance\HistoricalRequest', function ($app) {
            return new HistoricalRequest($app->make('GuzzleHttp\Client'));
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
