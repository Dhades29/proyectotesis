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
        Schema::create('respuestas', function (Blueprint $table) {
            $table->increments('IdRespuesta');
            $table->unsignedInteger('IdAsignacion');
            $table->unsignedInteger('IdPregunta');
            $table->text('RespuestaTexto')->nullable();
            $table->unsignedInteger('IdOpcion')->nullable();
            $table->dateTime('FechaRespuesta')->default(DB::raw('CURRENT_TIMESTAMP'));

            $table->foreign('IdAsignacion')->references('IdAsignacion')->on('Asignaciones')->onDelete('cascade');
            $table->foreign('IdPregunta')->references('IdPregunta')->on('Preguntas');
            $table->foreign('IdOpcion')->references('IdOpcion')->on('Opciones');
            $table->unique(['IdAsignacion', 'IdPregunta']);
        });

        // CHECK constraint
        DB::statement("ALTER TABLE `Respuestas` ADD CONSTRAINT chk_respuesta_valida CHECK (
            (IdOpcion IS NOT NULL AND RespuestaTexto IS NULL) OR
            (IdOpcion IS NULL AND RespuestaTexto IS NOT NULL)
        )");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('respuestas');
    }
};
