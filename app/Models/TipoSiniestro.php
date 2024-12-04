<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TipoSiniestro extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'tipo_siniestro';

    protected $fillable = [
        'tipo',
    ];

    public function siniestros()
    {
        return $this->hasMany(Siniestro::class, 'tipo_siniestro_id');
    }
}
