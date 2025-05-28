<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Preguntas extends Model
{
    // Nombre de la tabla
    protected $table = 'preguntas';

    // Clave primaria personalizada
    protected $primaryKey = 'IdPregunta';

    // Laravel asume que la clave primaria es auto-incremental y de tipo int
    public $incrementing = true;
    protected $keyType = 'int';

    // La tabla no tiene timestamps (created_at, updated_at)
    public $timestamps = false;

    // Campos asignables en masa
    protected $fillable = [
        'IdSeccion',
        'Texto',
        'TipoRespuesta',
        'Orden',
        'EsObligatoria',
    ];

    // Relación: una pregunta pertenece a una sección
    public function secciones()
    {
        return $this->belongsTo(Secciones::class, 'IdSeccion', 'IdSeccion');
    }
}
