<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/depot/{depotId}/stock/{stockId}/historical', 'YahooFinance\StockHistoricalController@historical')
    ->name('stock.historical');
Route::get('/stock/{stockId}/summary', 'YahooFinance\StockSummaryController@summary')
    ->name('stock.summary');
Route::get('/stock/{stockId}/statistics', 'YahooFinance\StockStatisticsController@statistics')
    ->name('stock.statistics');

Route::get('/dashboard', 'Dashboard\DashboardController@index')->name('dashboard');

Route::get('/depot', 'Depot\DepotController@index')->name('depot.index');
Route::post('/depot', 'Depot\DepotController@store')->name('depot.store');
Route::get('/depot/create', 'Depot\DepotController@create')->name('depot.create');
Route::get('/depot/{depot}', 'Depot\DepotController@show')->name('depot.show');
Route::patch('/depot/{depot}', 'Depot\DepotController@update')->name('depot.update');
Route::get('/depot/{depot}/edit', 'Depot\DepotController@edit')->name('depot.edit');
Route::delete('/depot/{depot}', 'Depot\DepotController@destroy')->name('depot.destroy');

Route::post('/depot/{depot}/stock', 'Depot\StockController@store')->name('stock.store');
Route::get('/depot/{depot}/stock/create', 'Depot\StockController@create')->name('stock.create');
Route::get('/depot/{depot}/stock/{stock}', 'Depot\StockController@show')->name('stock.show');
Route::patch('/depot/{depot}/stock/{stock}', 'Depot\StockController@update')->name('stock.update');
Route::get('/depot/{depot}/stock/{stock}/edit', 'Depot\StockController@edit')->name('stock.edit');
Route::delete('/depot/{depot}/stock', 'Depot\StockController@destroy')->name('stock.destroy');
