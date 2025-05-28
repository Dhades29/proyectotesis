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
        Schema::create('observaciones', function (Blueprint $table) {
            $table->increments('IdObservacion');
            $table->unsignedInteger('IdAsignacion');
            $table->unsignedInteger('IdClase');
            $table->date('FechaObservacion')->nullable();

            $table->foreign('IdAsignacion')->references('IdAsignacion')->on('asignaciones');
            $table->foreign('IdClase')->references('IdClase')->on('Clases');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('observaciones');
    }
};
