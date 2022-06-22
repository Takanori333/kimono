<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStylistInfosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stylist_infos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name', 20);
            $table->string('address', 100);
            $table->date('birthday');
            $table->boolean('sex');
            $table->string('phone', 20);
            $table->string('post', 7);
            $table->string('icon', 100);
            $table->integer('min_price')->nullable();
            $table->integer('max_price')->nullable();
            $table->double('point')->default(0);
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
        Schema::dropIfExists('stylist_infos');
    }
}
