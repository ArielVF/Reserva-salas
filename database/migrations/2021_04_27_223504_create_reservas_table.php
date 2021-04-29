<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReservasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reserva', function (Blueprint $table) {
            $table->id();
            //siempre sera la misma fecha para los dos, pero full calendar exige la estructura de inicio y fin.
            $table->string('title')->default('Reservas Activas'); //por defecto siempre sera reserva, fullcalendar exige esta columna.
            $table->string('descripcion'); //Titulo del asunto
            $table->date('start'); //Fecha reserva
            $table->date('end');
            
            //Claves foraneas
            $table->unsignedBigInteger('usuario_id'); 
            $table->foreign('usuario_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->unsignedBigInteger('espacioFisico_id'); 
            $table->foreign('espacioFisico_id')->references('id')->on('espacio_fisico')->onDelete('cascade')->onUpdate('cascade');
            $table->unsignedBigInteger('bloque_id'); 
            $table->foreign('bloque_id')->references('id')->on('bloque')->onDelete('cascade')->onUpdate('cascade');
        
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reserva');
    }
}
