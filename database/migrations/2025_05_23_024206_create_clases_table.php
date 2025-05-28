<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations
     */
    public function up(): void
    {
        Schema::create('clases', function (Blueprint $table) {
            $table->increments('IdClase');
            $table->unsignedInteger('IdMateria');
            $table->unsignedInteger('IdDocente');
            $table->unsignedInteger('IdCiclo');
            $table->unsignedInteger('IdCatedra');
            $table->string('Seccion', 10)->nullable();
            $table->string('Aula', 50)->nullable();
            $table->string('Edificio', 100)->nullable();
            $table->string('DiaSemana', 20)->nullable();
            $table->time('HoraInicio')->nullable();
            $table->time('HoraFin')->nullable();
            $table->integer('Inscritos')->nullable();

            $table->foreign('IdMateria')->references('IdMateria')->on('materia');
            $table->foreign('IdDocente')->references('IdDocente')->on('docentes');
            $table->foreign('IdCiclo')->references('IdCiclo')->on('ciclos');
            $table->foreign('IdCatedra')->references('IdCatedra')->on('catedras');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clases');
    }
};
