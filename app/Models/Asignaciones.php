<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Asignaciones extends Model
{
    // Nombre de la tabla
    protected $table = 'asignaciones';

    // Clave primaria personalizada
    protected $primaryKey = 'IdAsignacion';

    // Laravel asume que la clave primaria es auto-incremental y de tipo int
    public $incrementing = true;
    protected $keyType = 'int';

    // La tabla no tiene timestamps (created_at, updated_at)
    public $timestamps = false;

    // Campos asignables en masa
    protected $fillable = [
        'IdFormulario',
        'IdUsuario',
        'IdClase',
        'FechaAsignacion',
        'FechaCompletado',
    ];

    // Relaciones Eloquent

    public function formularios()
    {
        return $this->belongsTo(Formularios::class, 'IdFormulario', 'IdFormulario');
    }

    public function clases()
    {
        return $this->belongsTo(Clases::class, 'IdClase', 'IdClase');
    }

    public function usuarios()
    {
        return $this->belongsTo(Usuarios::class, 'IdUsuario', 'IdUsuario');
    }
}
