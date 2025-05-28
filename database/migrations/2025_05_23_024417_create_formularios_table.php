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
        Schema::create('formularios', function (Blueprint $table) {
            $table->increments('IdFormulario');
            $table->string('NombreFormulario', 100);
            $table->string('Descripcion', 150)->nullable();
            $table->dateTime('FechaCreacion')->default(DB::raw('CURRENT_TIMESTAMP'));

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('formularios');
    }
};
