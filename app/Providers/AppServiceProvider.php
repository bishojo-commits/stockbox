<?php

namespace App\Providers;

use App\Http\Controllers\YahooFinance\StockStatisticsController;
use App\Services\YahooFinance\HistoricalConnector;
use App\Services\YahooFinance\StatisticsConnector;
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
        $this->app->bind('App\Http\Controllers\YahooFinance\StockStatisticsController', function ($app) {
            return new StockStatisticsController($app->make('App\Services\YahooFinance\StatisticsConnector'));
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
