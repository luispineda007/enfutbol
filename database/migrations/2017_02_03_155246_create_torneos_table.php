<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTorneosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('torneos', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombre');
            $table->integer('usuario_id')->unsigned();
            $table->integer('sitio_id')->unsigned()->nullable();
            $table->string('lugar')->nullable();
            $table->integer('max_equipos');
            $table->integer('max_jugadores');
            $table->date('maxFecha_inscripcion'); //Almacenara la fecha maxima para inscribirse al torneo
            $table->mediumText('descripcion'); //Contendra los datos relevantes y descriptivos del torneo
            $table->string('url_logo');
            $table->string('tipo_cancha');
            $table->enum('genero', ['M', 'F']);
            $table->integer('vlr_inscripcion');
            $table->mediumText('premiacion'); //Almacenara los premios que se entregaran a cada lugar premiado
            $table->enum('estado',['A','C','T']); //A Si aun se pueden inscribir, C si ya pasaron inscripciones , T si el torneo Termino
            $table->enum('privacidad',['A','C']); //A si cualquiera puede inscribirse, C si solo se pueden inscribir mediante codigo
            $table->integer('municipio_id')->unsigned();

            $table->timestamps();
            $table->foreign('usuario_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
            $table->foreign('municipio_id')
                ->references('id')
                ->on('municipios')
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
        Schema::drop('torneos');
    }
}
