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
        Schema::create('usuarios', function (Blueprint $table) {
            $table->increments('IdUsuario');
            $table->string('Nombre', 50);
            $table->string('Apellido', 50);
            $table->string('NombreUsuario', 50)->unique();
            $table->string('Password', 255);
            $table->unsignedInteger('IdRol');
            $table->date('FechaRegistro')->default(DB::raw('CURRENT_DATE'));
            $table->foreign('IdRol')->references('IdRol')->on('roles');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('usuarios');
    }
};
