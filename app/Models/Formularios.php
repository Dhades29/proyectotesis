<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Materia;

class Formularios extends Model
{
    // Nombre de la tabla
    protected $table = 'formularios';

    // Clave primaria personalizada
    protected $primaryKey = 'IdFormulario';

    // Laravel asume que la clave primaria es auto-incremental y de tipo int
    public $incrementing = true;
    protected $keyType = 'int';

    // La tabla no tiene timestamps (created_at, updated_at)
    public $timestamps = false;

    // Campos asignables en masa
    protected $fillable = [
        'NombreFormulario',
        'Descripcion',
        'FechaCreacion',
    ];
}