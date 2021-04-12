<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTallerTable extends Migration
{
    /*
     *
     * Run the migrations.
     *
     * @return void
    */
    public function up()
    {
        Schema::create('taller', function (Blueprint $table) {
            $table->increments('idTaller');
            $table->string('nombreTaller', 70);
            $table->string('nombrePonente', 70);
            $table->integer('idEscuela')->unsigned();
            $table->foreign('idEscuela')->references('id')->on('escuelas');
            $table->longtext('descripcion');
            $table->dateTime('fecha');
            $table->string('hora');
            $table->string('foto');
            $table->string('agroup');
            $table->boolean('vigencia')->default(1);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('taller');
    }
}
