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
}
