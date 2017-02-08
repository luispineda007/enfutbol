<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEquiposTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('equipos', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombre');
            $table->enum('genero', ['M', 'F']);
            $table->integer('capitan_id')->unsigned();
            $table->integer('escudo_id')->unsigned();

            $table->timestamps();
            $table->foreign('capitan_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
            $table->foreign('escudo_id')
                ->references('id')
                ->on('escudos')
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
        Schema::drop('equipos');
    }
}
