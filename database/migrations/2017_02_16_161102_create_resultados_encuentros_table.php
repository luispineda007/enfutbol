<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateResultadosEncuentrosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('resultados_encuentros', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('encuentro_id')->unsigned();
            $table->string('resultado')->nullable();
            $table->string('amarillas')->nullable();
            $table->string('rojas')->nullable();
            $table->string('azules')->nullable();

            $table->timestamps();
            $table->foreign('encuentro_id')
                ->references('id')
                ->on('encuentros')
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
        Schema::drop('resultados_encuentros');
    }
}
