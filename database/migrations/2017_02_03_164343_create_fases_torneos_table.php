<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFasesTorneosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fases_torneos', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('torneo_id')->unsigned();
            $table->char('numero_fase'); //Almacenara el numero de la fase 1 , 2, 3, ... n
            $table->string('nombre_fase'); //Almacenara el nombre de la fase Ej: Eliminatorias, clasificacion
            $table->integer('num_clasificados'); //Almacenara el numero total de clasificados por grupo o por fase
            $table->enum('tipo_juego', ['TvT', 'TvTG', 'D']);
            $table->integer('num_grupos');

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
        Schema::drop('fases_torneos');
    }
}
