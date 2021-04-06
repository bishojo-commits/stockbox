<?php

namespace App\Providers;

use App\Http\Controllers\YahooFinance\DepotFinancialsController;
use App\Http\Controllers\YahooFinance\StockHistoricalController;
use App\Http\Controllers\YahooFinance\StockStatisticsController;
use App\Http\Controllers\YahooFinance\StockSummaryController;
use App\Services\YahooFinance\ConnectorInterface;
use App\Services\YahooFinance\FinancialConnector;
use App\Services\YahooFinance\HistoricalConnector;
use App\Services\YahooFinance\StatisticsConnector;
use App\Services\YahooFinance\SummaryConnector;
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
        $this->app->when(StockStatisticsController::class)
            ->needs(ConnectorInterface::class)
            ->give(function () {
                return new StatisticsConnector($this->app->make('GuzzleHttp\Client'));
            });

        $this->app->when(StockHistoricalController::class)
            ->needs(ConnectorInterface::class)
            ->give(function () {
                return new HistoricalConnector($this->app->make('GuzzleHttp\Client'));
            });

        $this->app->when(StockSummaryController::class)
            ->needs(ConnectorInterface::class)
            ->give(function () {
                return new SummaryConnector($this->app->make('GuzzleHttp\Client'));
            });

        $this->app->when(DepotFinancialsController::class)
            ->needs(ConnectorInterface::class)
            ->give(function () {
                return new FinancialConnector($this->app->make('GuzzleHttp\Client'));
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
