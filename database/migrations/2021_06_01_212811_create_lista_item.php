<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateListaItem extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lista_item', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_lista');
            $table->unsignedBigInteger('id_item');
            $table->integer('is_checked')->default(0);
            $table->foreign('id_lista')->references('id')->on('lista');
            $table->foreign('id_item')->references('id')->on('item');
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
        Schema::dropIfExists('lista_item');
    }
}
