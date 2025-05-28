<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Catedras extends Model
{
    // Nombre de la tabla
    protected $table = 'catedras';

    // Clave primaria personalizada
    protected $primaryKey = 'IdCatedra';

    // Laravel asume que la clave primaria es auto-incremental y de tipo int
    public $incrementing = true;
    protected $keyType = 'int';

    // Si la tabla no tiene timestamps (created_at, updated_at)
    public $timestamps = false;

    // Campos asignables en masa
    protected $fillable = [
        'NombreCatedra',
    ];
}
