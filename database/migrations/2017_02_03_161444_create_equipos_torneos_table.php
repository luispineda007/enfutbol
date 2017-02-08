<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEquiposTorneosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('equipos_torneos', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('torneo_id')->unsigned();
            $table->integer('equipo_id')->unsigned();
            $table->enum('estado', ['A', 'C', 'P']); //A: El capitan puede modificar equipo, B: No puede modificar, P El equipo espera aprobacion en el torneo

            $table->timestamps();
            $table->foreign('torneo_id')
                ->references('id')
                ->on('torneos')
                ->onDelete('cascade');
            $table->foreign('equipo_id')
                ->references('id')
                ->on('equipos')
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
        Schema::drop('equipos_torneos');
    }
}
