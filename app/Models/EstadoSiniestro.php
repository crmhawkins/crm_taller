<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EstadoSiniestro extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'estados_siniestro';

    protected $fillable = [
        'estado',
    ];

    public function siniestros()
    {
        return $this->hasMany(Siniestro::class, 'estado_siniestro_id');
    }


}
