<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Observaciones extends Model
{
    // Nombre de la tabla (opcional si sigue la convención)
    protected $table = 'observaciones';

    // Clave primaria personalizada
    protected $primaryKey = 'IdObservacion';

    // Si la clave primaria no es auto-incremental tipo int, ajustar $incrementing y $keyType
    public $incrementing = true;
    protected $keyType = 'int';

    // Laravel por defecto espera timestamps (created_at, updated_at)
    public $timestamps = false;

    // Campos asignables en masa
    protected $fillable = [
        'IdAsignacion',
        'IdClase',
        'FechaObservacion',
    ];

    // Relación con Asignacion
    public function asignaciones()
    {
        return $this->belongsTo(Asignaciones::class, 'IdAsignacion', 'IdAsignacion');
    }

    // Relación con Clases
    public function clases()
    {
        return $this->belongsTo(Clases::class, 'IdClase', 'IdClase');
    }
}
