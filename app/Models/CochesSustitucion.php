<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CochesSustitucion extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'matricula',
        'seguro',
        'marca',
        'vin',
        'modelo',
        'kilometraje',
        'color',
        'anio',
        
    ];
    protected $table = 'coches_sustitucion';

    public function reservasCoche()
    {
        return $this->hasMany(ReservasCoche::class, 'coche_sustitucion_id');
    }
    //is disponible si no tiene ninguna reserva con estado pendiente o entregado
    public function isDisponible()
    {
        return $this->reservasCoche()
                    ->whereIn('estado', ['pendiente', 'entregado'])
                    ->count() === 0;
    }
}
