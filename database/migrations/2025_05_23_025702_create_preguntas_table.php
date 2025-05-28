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
        Schema::create('preguntas', function (Blueprint $table) {
            $table->increments('IdPregunta');
            $table->unsignedInteger('IdSeccion');
            $table->string('Texto', 255);
            $table->enum('TipoRespuesta', ['texto', 'seleccion', 'multiple', 'booleano']);
            $table->integer('Orden')->default(0);
            $table->boolean('EsObligatoria')->default(true);

            $table->foreign('IdSeccion')->references('IdSeccion')->on('secciones')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('preguntas');
    }
};
