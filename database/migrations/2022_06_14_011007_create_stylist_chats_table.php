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
        Schema::create('stylist_chats', function (Blueprint $table) {
            $table->id();
            $table->integer("stylist_id");
            $table->integer("customer_id");
            $table->text("text");
            $table->integer("from");            
            $table->boolean("read")->default(0);
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
};
