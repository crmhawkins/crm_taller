<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Suppliers\Supplier;
class Piezas extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'nombre', 'codigo', 'fabricante', 'foto', 'marca', 'modelo', 'descripcion', 'nota', 'proveedor_id', 'numero_serie', 'categoria_id'
    ];

    public function categoria()
    {
        return $this->belongsTo(CategoriasPiezas::class);
    }

    public function proveedor()
    {
        return $this->belongsTo(Supplier::class);
    }
}
