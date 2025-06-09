<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Materias extends Model
{
    protected $table = 'Materia';

    // Clave primaria personalizada
    protected $primaryKey = 'IdMateria';
    public $timestamps = false;

    // Campos que se pueden asignar de forma masiva
    protected $fillable = [
        'CodigoMateria',
        'Nombre',
        'Modalidad'
    ];

    
}
