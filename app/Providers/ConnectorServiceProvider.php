<?php

namespace App\Providers;

use App\Services\YahooFinance\HistoricalConnector;
use App\Services\YahooFinance\StatisticsConnector;
use Illuminate\Support\ServiceProvider;

class ConnectorServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('App\Services\YahooFinance\HistoricalConnector', function ($app) {
            return new HistoricalConnector($app->make('GuzzleHttp\Client'));
        });

        $this->app->bind('App\Services\YahooFinance\StatisticsConnector', function ($app) {
            return new StatisticsConnector($app->make('GuzzleHttp\Client'));
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
