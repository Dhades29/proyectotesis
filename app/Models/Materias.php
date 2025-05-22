<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Materia extends Model
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

    // Relación con Formularios (uno a muchos)
    public function formularios()
    {
        return $this->hasMany(Formularios::class, 'IdMateria', 'IdMateria');
    }
}
