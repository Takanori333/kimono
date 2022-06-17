<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItemInfosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('item_infos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name', 20);
            $table->string('detail', 200);
            $table->integer('price');
            $table->string('category', 50);
            $table->string('material', 50);
            $table->string('item_status', 50);
            $table->string('smell', 50);
            $table->string('color', 50);
            $table->double('height', 8, 2);
            $table->double('length', 8, 2);
            $table->double('sleeve', 8, 2);
            $table->double('sleeves', 8, 2);
            $table->double('front', 8, 2);
            $table->double('back', 8, 2);
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
        Schema::dropIfExists('item_infos');
    }
}
