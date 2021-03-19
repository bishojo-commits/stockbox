<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDepotStockTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('depot_stock', function (Blueprint $table) {
            $table->primary(['depot_id', 'stock_id']);
            $table->bigInteger('depot_id')->unsigned()->index();
            $table->bigInteger('stock_id')->unsigned()->index();
            $table->unsignedBigInteger('quantity')->default(0);
            $table->unsignedFloat('buy_price');
            $table->date('buy_date');
            $table->string('buy_currency');
            $table->timestamps();

            $table->foreign('depot_id')->references('id')->on('depots')->cascadeOnDelete();
            $table->foreign('stock_id')->references('id')->on('stocks')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('depot_user');
    }
}
