<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Clients\Client;

class Coches extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'matricula',
        'seguro',
        'marca',
        'vin',
        'modelo',
        'kilometraje',
        'color',
        'anio',
        'cliente_id',
        'foto',
    ];

    public function cliente()
    {
        return $this->belongsTo(Client::class);
    }

    public function siniestros()
    {
        return $this->hasMany(Siniestro::class, 'coche_id');
    }

}
