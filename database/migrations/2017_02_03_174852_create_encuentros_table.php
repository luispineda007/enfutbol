<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEncuentrosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('encuentros', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('torneo_id')->unsigned();
            $table->date('fecha');
            $table->string('hora');
            $table->integer('equipo1_id')->unsigned();
            $table->integer('equipo2_id')->unsigned();
            $table->string('lugar');

            $table->timestamps();
            $table->foreign('torneo_id')
                ->references('id')
                ->on('torneos')
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
        Schema::drop('encuentros');
    }
}
