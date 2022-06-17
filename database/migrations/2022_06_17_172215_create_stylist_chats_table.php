<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStylistChatsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stylist_chats', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('stylist_id');
            $table->integer('customer_id');
            $table->text('text');
            $table->boolean('from');
            $table->tinyInteger('readed')->default(1);
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
        Schema::dropIfExists('stylist_chats');
    }
}
