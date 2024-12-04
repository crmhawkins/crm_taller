<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Seguro extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'seguros';

    protected $fillable = [
        'identificador',
        'aseguradora',
        'responsable',
        'telefono',
        'notas',
        'precio',
    ];
}
