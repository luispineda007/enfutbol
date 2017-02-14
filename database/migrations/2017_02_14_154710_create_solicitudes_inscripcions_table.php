<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSolicitudesInscripcionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('solicitudes_inscripcions', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('torneo_id')->unsigned();
            $table->integer('equipo_id')->unsigned();
            $table->integer('capitan_id')->unsigned();
            $table->enum('estado', ['P', 'R']); //P: El administrador no ha respondido a la solicitud, R:Solicitud rechazada

            $table->timestamps();
            $table->foreign('torneo_id')
                ->references('id')
                ->on('torneos')
                ->onDelete('cascade');
            $table->foreign('equipo_id')
                ->references('id')
                ->on('equipos')
                ->onDelete('cascade');
            $table->foreign('capitan_id')
                ->references('id')
                ->on('users')
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
        Schema::drop('solicitudes_inscripcions');
    }
}
