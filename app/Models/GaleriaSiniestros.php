<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Siniestro;

class GaleriaSiniestros extends Model
{
    use HasFactory;

    protected $table = 'galeria_siniestros';

    protected $fillable = ['imagen', 'siniestro_id'];

    public function siniestro()
    {
        return $this->belongsTo(Siniestro::class);
    }
}
