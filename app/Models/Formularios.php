<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Materia;

class Formularios extends Model
{
    protected $table = 'Formularios';

    protected $primaryKey = 'IdFormulario';
    public $timestamps = false;

    protected $fillable = [
        'IdMateria',
        'NombreFormulario',
        'Descripcion',
        'FechaCreacion',
        'Estado'
    ];

    public function materia()
    {
        return $this->belongsTo(Materia::class, 'IdMateria', 'IdMateria');
    }
}