<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Coches;
class VisitaCoche extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'visita_coche';

    protected $fillable = [
        'coche_id',
        'fecha_ingreso',
        'fecha_salida',
        'kilometraje',
        'color',
        'ingreso_grua',
        'trabajo_a_realizar',
        'observaciones',
        'airbag',
        'motor',
        'abs',
        'aceite',
        'bateria',
        'cinturon',
        'parking',
        'luces',
        'neumaticos',
        'temperatura',
        'gato',
        'herramientas',
        'triangulos',
        'tapas',
        'llanta',
        'extintor',
        'antena',
        'emblemas',
        'tapones',
        'cables',
        'radio',
        'encendedor',
        'nivel_gasolina',
        'foto_daños',
    ];


    public function coche()
    {
        return $this->belongsTo(Coches::class);
    }

    public function budget()
    {
        return $this->belongsTo(Budget::class, 'visita_id');
    }
}
