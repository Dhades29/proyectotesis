<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations
     */
    public function up(): void
    {
        Schema::create('asignaciones', function (Blueprint $table) {
            $table->increments('IdAsignacion');
            $table->unsignedInteger('IdFormulario');
            $table->unsignedInteger('IdUsuario');
            $table->unsignedInteger('IdClase');
            $table->dateTime('FechaAsignacion')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->dateTime('FechaCompletado')->nullable();

            $table->foreign('IdFormulario')->references('IdFormulario')->on('formularios');
            $table->foreign('IdClase')->references('IdClase')->on('clases');
            $table->foreign('IdUsuario')->references('IdUsuario')->on('usuarios');
            $table->unique(['IdFormulario', 'IdUsuario']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('asignaciones');
    }
};
