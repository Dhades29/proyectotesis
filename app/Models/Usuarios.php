<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Usuarios extends Model
{
    protected $table = 'usuarios';

    // Clave primaria personalizada
    protected $primaryKey = 'IdUsuario';
    public $timestamps = false;

    // Campos que se pueden asignar de forma masiva
    protected $fillable = [
        'Nombre',
        'Apellido',
        'NombreUsuario',
        'Password',
        'IdRol'
    ];  

    // Relación con la tabla de roles (si existe)
    public function rol()
    {
        return $this->belongsTo(Roles::class, 'IdRol', 'IdRol');
    }

    
}
