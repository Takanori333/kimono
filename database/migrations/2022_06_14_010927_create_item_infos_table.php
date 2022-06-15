<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('item_infos', function (Blueprint $table) {
            $table->id();
            $table->string("name",20);
            $table->string("detail",200);
            $table->integer("price");
            $table->string("category",50);
            $table->string("material",50);
            $table->string("item_status",50);
            $table->string("smell",50);
            $table->string("color",50);
            $table->float("height");
            $table->float("length");
            $table->float("sleeve");
            $table->float("sleeves");
            $table->float("front");
            $table->float("back");
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
};
