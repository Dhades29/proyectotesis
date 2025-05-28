<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Clases extends Model
{
    // Nombre de la tabla
    protected $table = 'clases';

    // Clave primaria personalizada
    protected $primaryKey = 'IdClase';

    // Laravel asume que la clave primaria es auto-incremental y de tipo int
    public $incrementing = true;
    protected $keyType = 'int';

    // La tabla no tiene timestamps (created_at, updated_at)
    public $timestamps = false;

    // Campos asignables en masa
    protected $fillable = [
        'IdMateria',
        'IdDocente',
        'IdCiclo',
        'IdCatedra',
        'Seccion',
        'Aula',
        'Edificio',
        'DiaSemana',
        'HoraInicio',
        'HoraFin',
        'Inscritos',
    ];

    // Relaciones Eloquent

    public function materias()
    {
        return $this->belongsTo(Materia::class, 'IdMateria', 'IdMateria');
    }

    public function docentes()
    {
        return $this->belongsTo(Docentes::class, 'IdDocente', 'IdDocente');
    }

    public function ciclos()
    {
        return $this->belongsTo(Ciclos::class, 'IdCiclo', 'IdCiclo');
    }

    public function catedras()
    {
        return $this->belongsTo(Catedras::class, 'IdCatedra', 'IdCatedra');
    }
}
