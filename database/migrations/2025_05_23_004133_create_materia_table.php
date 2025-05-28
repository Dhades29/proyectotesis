<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('materia', function (Blueprint $table) {
            $table->increments('IdMateria');
            $table->string('CodigoMateria', 20)->nullable();
            $table->string('Nombre', 50)->nullable();
            $table->string('Modalidad', 25)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('materia');
    }
};
