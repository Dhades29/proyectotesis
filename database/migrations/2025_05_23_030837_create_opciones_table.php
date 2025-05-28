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
        Schema::create('opciones', function (Blueprint $table) {
            $table->increments('IdOpcion');
            $table->unsignedInteger('IdPregunta');
            $table->string('Texto', 100);
            $table->integer('Orden')->default(0);

            $table->foreign('IdPregunta')->references('IdPregunta')->on('preguntas')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('opciones');
    }
};
