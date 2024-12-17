<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Clients\Client;

class Appointment extends Model
{
    use HasFactory;

    protected $fillable = ['client_id', 'name', 'phone', 'appointment_date', 'vehicle_details', 'notes', 'estado'];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }
}
