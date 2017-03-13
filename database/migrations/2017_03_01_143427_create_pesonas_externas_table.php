<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePesonasExternasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pesonas_externas', function (Blueprint $table) {
            $table->increments('id');
            $table->string('identificacion');
            $table->string('nombres');
            $table->string('telefono');
            $table->integer('id_municipio')->unsigned();
            $table->enum('sexo', ['F', 'M'])->nullable();
            $table->date('fecha_nacimiento')->nullable();
            $table->timestamps();
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
        Schema::drop('pesonas_externas');
    }
}
