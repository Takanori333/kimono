<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStylistReservesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stylist_reserves', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('reserve_id', 200);
            $table->integer('stylist_id');
            $table->integer('customer_id');
            $table->integer('price');
            $table->text('services');
            $table->dateTime('start_time');
            $table->dateTime('end_time');
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
        Schema::dropIfExists('stylist_reserves');
    }
}
