<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Roles extends Model
{
    // Nombre de la tabla
    protected $table = 'Roles';

    // Clave primaria
    protected $primaryKey = 'IdRol';

    public $timestamps = false;

    // Campos que se pueden asignar masivamente
    protected $fillable = [
        'NombreRol',
    ];

    // Relación con la tabla Usuarios (uno a muchos)
    public function usuarios()
    {
        return $this->hasMany(Usuarios::class, 'IdRol', 'IdRol');
    }
}