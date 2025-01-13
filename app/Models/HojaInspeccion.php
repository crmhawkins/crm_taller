<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
//soft delete
use Illuminate\Database\Eloquent\SoftDeletes;

class HojaInspeccion extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'hoja_inspeccion';

    protected $fillable = [
        'fecha',
        'matricula',
        'coche_id',
        'nivel_aceite',
        'observaciones_aceite',
        'nivel_liquido_refrigerante',
        'observaciones_liquido_refrigerante',
        'nivel_liquido_frenos_embrague',
        'observaciones_liquido_frenos_embrague',
        'nivel_limpiaparabrisas',
        'observaciones_nivel_limpiaparabrisas',
        'estado_correas',
        'observaciones_correas',
        'intermitente',
        'observaciones_intermitente',
        'frenado',
        'observaciones_frenado',
        'marcha_atras',
        'observaciones_marcha_atras',
        'luces',
        'observaciones_luces',
        'reglaje_faros',
        'observaciones_reglaje_faros',
        'antinieblas',
        'observaciones_antinieblas',
        'estado_neumaticos',
        'observaciones_estado_neumaticos',
        'presion_neumaticos',
        'observaciones_presion_neumaticos',
        'amortiguadores',
        'observaciones_amortiguadores',
        'holguras',
        'observaciones_holguras',
        'desgastes_frenos',
        'observaciones_desgastes_frenos',
        'tension_freno_mano',
        'observaciones_tension_freno_mano',
        'fugas',
        'observaciones_fugas',
        'limpiaparabrisas',
        'observaciones_limpiaparabrisas',
        'cinturones_seguridad',
        'observaciones_cinturones_seguridad',
        'firma_cliente',
    ];
}
