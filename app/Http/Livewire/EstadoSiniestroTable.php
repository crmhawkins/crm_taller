<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\EstadoSiniestro;

class EstadoSiniestroTable extends Component
{
    public function render()
    {
        $estados = EstadoSiniestro::all();
        return view('livewire.estado-siniestro-table', compact('estados'));
    }
}
