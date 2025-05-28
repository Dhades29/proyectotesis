<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Opciones extends Model
{
    // Nombre de la tabla
    protected $table = 'opciones';

    // Clave primaria personalizada
    protected $primaryKey = 'IdOpcion';

    // Laravel asume que la clave primaria es auto-incremental y de tipo int
    public $incrementing = true;
    protected $keyType = 'int';

    // La tabla no tiene timestamps (created_at, updated_at)
    public $timestamps = false;

    // Campos asignables en masa
    protected $fillable = [
        'IdPregunta',
        'Texto',
        'Orden',
    ];

    // Relación: una opción pertenece a una pregunta
    public function preguntas()
    {
        return $this->belongsTo(Preguntas::class, 'IdPregunta', 'IdPregunta');
    }
}
