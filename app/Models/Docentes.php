<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Docentes extends Model
{
    // Nombre de la tabla
    protected $table = 'docentes';

    // Clave primaria personalizada
    protected $primaryKey = 'IdDocente';

    // Laravel asume que la clave primaria es auto-incremental y de tipo int
    public $incrementing = true;
    protected $keyType = 'int';

    // Si la tabla no tiene timestamps (created_at, updated_at)
    public $timestamps = false;

    // Campos asignables en masa
    protected $fillable = [
        'Nombre',
        'Apellido',
    ];
}
