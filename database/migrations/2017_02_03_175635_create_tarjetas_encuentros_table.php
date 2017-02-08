<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTarjetasEncuentrosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tarjetas_encuentros', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('jugador_id')->unsigned();
            $table->integer('encuentro_id')->unsigned();
            $table->integer('rojas');
            $table->integer('amarillas');
            $table->integer('azules');

            $table->timestamps();
            $table->foreign('jugador_id')
                ->references('id')
                ->on('jugadors')
                ->onDelete('cascade');
            $table->foreign('encuentro_id')
                ->references('id')
                ->on('encuentros')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('tarjetas_encuentros');
    }
}
