<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateImplementosDeEspaciosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('implementos_de_espacios', function (Blueprint $table) {
            $table->id();
            
            //Claves foraneas
            $table->unsignedBigInteger('implemento_id'); 
            $table->foreign('implemento_id')->references('id')->on('implemento')->onDelete('cascade')->onUpdate('cascade');
            $table->unsignedBigInteger('espacioFisico_id'); 
            $table->foreign('espacioFisico_id')->references('id')->on('espacio_fisico')->onDelete('cascade')->onUpdate('cascade');
            $table->Integer('cantidad');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('implementos_de_espacios');
    }
}
