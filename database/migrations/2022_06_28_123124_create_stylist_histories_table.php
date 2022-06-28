<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStylistHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stylist_histories', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('stylist_id');
            $table->integer('customer_id');
            $table->dateTime('start_time');
            $table->dateTime('end_time');
            $table->integer('price');
            $table->string('address');
            $table->text('services');
            $table->integer('count');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('stylist_histories');
    }
}
