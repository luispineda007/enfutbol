<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCanchasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('canchas', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_padre')->unsigned();
            $table->integer('id_sitio')->unsigned();
            $table->string('nombre',60);
            $table->string('tipo',20);
            $table->string('foto')->default("DefaultCancha.jpg");
            $table->integer('precio_base');
            $table->integer('precio_nocturno');
            $table->integer('precio_festivo');
            $table->mediumText('descripcion');
            $table->timestamps();
            $table->foreign('id_sitio')
                ->references('id')
                ->on('sitios')
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
        Schema::drop('canchas');
    }
}
