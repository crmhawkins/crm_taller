<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\HasMedia;
use App\Models\Clients\Client;

class Siniestro extends Model implements HasMedia
{
    use HasFactory, SoftDeletes, InteractsWithMedia;

    protected $table = 'siniestro';

    protected $fillable = [
        'identificador',
        'fecha',
        'poliza',
        'coche_id',
        'cliente_id',
        'descripcion',
        'daños',
        'coste_reparacion',
        'inicio_reparacion',
        'fin_reparacion',
        'monto_aseguradora',
        'monto_cliente',
        'comentarios',
        'prioridad',
        'tipo_siniestro_id',
        'estado_siniestro_id',
        'seguro_id',
        'peritaje',
        'peritaje_externo',

    ];

    public function cliente()
    {
        return $this->belongsTo(Client::class, 'cliente_id');
    }

    public function seguro()
    {
        return $this->belongsTo(Seguro::class, 'seguro_id');
    }

    public function tipoSiniestro()
    {
        return $this->belongsTo(TipoSiniestro::class, 'tipo_siniestro_id');
    }

    public function estadoSiniestro()
    {
        return $this->belongsTo(EstadoSiniestro::class, 'estado_siniestro_id');
    }

    public function coche()
    {
        return $this->belongsTo(Coches::class, 'coche_id');
    }   

    public function galeriaSiniestros()
    {
        return $this->hasMany(GaleriaSiniestros::class);
    }

    public function budget()
    {
        return $this->belongsTo(Budget::class, 'budget_id');
    }


}
