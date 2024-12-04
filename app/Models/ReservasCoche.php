<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\CochesSustitucion;
use App\Models\Clients\Client;
use Illuminate\Database\Eloquent\SoftDeletes;

class ReservasCoche extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'reservas_coche';

    protected $fillable = [
        'coche_sustitucion_id',
        'cliente_id',
        'fecha_inicio',
        'fecha_fin',
        'estado',
        'comentario',
        'km_actual',
        'km_entregado',

    ];

    public function cocheSustitucion()
    {
        return $this->belongsTo(CochesSustitucion::class);
    }

    public function cliente()
    {
        return $this->belongsTo(Client::class);
    }


}
