<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Respuestas extends Model
{
    // Nombre de la tabla (opcional si sigue la convención)
    protected $table = 'respuestas';

    // Clave primaria personalizada
    protected $primaryKey = 'IdRespuesta';

    public $incrementing = true;
    protected $keyType = 'int';

    // Laravel por defecto espera timestamps (created_at, updated_at)
    public $timestamps = false;

    // Campos asignables en masa
    protected $fillable = [
        'IdAsignacion',
        'IdPregunta',
        'RespuestaTexto',
        'IdOpcion',
        'FechaRespuesta',
    ];

    // Relación con Asignacion
    public function asignaciones()
    {
        return $this->belongsTo(Asignaciones::class, 'IdAsignacion', 'IdAsignacion');
    }

    // Relación con Pregunta
    public function preguntas()
    {
        return $this->belongsTo(Preguntas::class, 'IdPregunta', 'IdPregunta');
    }

    // Relación con Opcion
    public function opciones()
    {
        return $this->belongsTo(Opciones::class, 'IdOpcion', 'IdOpcion');
    }
}
