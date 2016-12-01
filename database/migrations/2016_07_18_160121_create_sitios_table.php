<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSitiosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sitios', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombre');
            $table->integer('id_usuario')->unsigned();
            $table->enum('estado_pago',['A','I']);
            $table->date('fecha_registro');
            $table->integer('id_municipio')->unsigned();
            $table->mediumText('info_adicional');
            $table->string('servicios', 255);
            $table->string('direccion', 80);
            $table->string('facebook');
            $table->string('twitter');
            $table->string('geolocalizacion');
            $table->timestamps();
            $table->foreign('id_usuario')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
            $table->foreign('id_municipio')
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
        Schema::drop('sitios');
    }
}
