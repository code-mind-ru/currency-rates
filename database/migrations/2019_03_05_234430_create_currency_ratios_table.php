<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCurrencyRatiosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('currency_ratios', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->char('cbr_code', 10);
            $table->double('price')->nullable();
            $table->date('date');
            $table->timestamps();
            $table->foreign('cbr_code')->references('cbr_code')->on('currencies')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('currency_ratios');
    }
}
