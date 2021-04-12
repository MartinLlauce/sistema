<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateListadoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('listado', function (Blueprint $table) {
            $table->increments('idListado');
            $table->integer('idPersona')->unsigned();
            $table->foreign('idPersona')->references('id')->on('entidad')->onDelete('cascade');
            $table->integer('idTaller')->unsigned();
            $table->foreign('idTaller')->references('idTaller')->on('taller')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('listado');
    }
}
