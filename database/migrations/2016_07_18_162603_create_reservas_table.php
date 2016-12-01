<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReservasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reservas', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_cancha')->unsigned();
            $table->integer('id_token')->unsigned();
            $table->string('responsable',100);
            $table->string('telefono',20);
            $table->date('fecha');
            $table->string('hora',5);
            $table->enum('estado',['','A','I']);
            $table->string('motivo');
            $table->timestamps();
            $table->foreign('id_cancha')
                ->references('id')
                ->on('canchas')
                ->onDelete('cascade');
            $table->foreign('id_token')
                ->references('id')
                ->on('tokens')
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
        Schema::drop('reservas');
    }
}
