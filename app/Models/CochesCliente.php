<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Clients\Client;

class CochesCliente extends Model
{
    use HasFactory;
    protected $fillable = [
        'cliente_id',
        'coche_id',
    ];

    public function cliente()
    {
        return $this->belongsTo(Client::class);
    }

    public function coche()
    {
        return $this->belongsTo(Coches::class);
    }
}
