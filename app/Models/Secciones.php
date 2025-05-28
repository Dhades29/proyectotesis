<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Secciones extends Model
{
    // Nombre de la tabla
    protected $table = 'secciones';

    // Clave primaria personalizada
    protected $primaryKey = 'IdSeccion';

    // Laravel asume que la clave primaria es auto-incremental y de tipo int
    public $incrementing = true;
    protected $keyType = 'int';

    // La tabla no tiene timestamps (created_at, updated_at)
    public $timestamps = false;

    // Campos asignables en masa
    protected $fillable = [
        'IdFormulario',
        'Titulo',
        'Orden',
    ];

    // Relación: una sección pertenece a un formulario
    public function formularios()
    {
        return $this->belongsTo(Formularios::class, 'IdFormulario', 'IdFormulario');
    }
}
