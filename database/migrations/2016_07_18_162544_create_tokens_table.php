<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTokensTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tokens', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_sitio')->unsigned();
            $table->integer('id_usuario')->unsigned();
            $table->enum('tipo',['normal','VIP']);
            $table->date('fecha');
            $table->enum('estado',['A','I']);
            $table->string('motivo');
            $table->timestamps();
            $table->foreign('id_sitio')
                ->references('id')
                ->on('sitios')
                ->onDelete('cascade');
            $table->foreign('id_usuario')
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
        Schema::drop('tokens');
    }
}
