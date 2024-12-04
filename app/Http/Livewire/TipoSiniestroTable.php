<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\TipoSiniestro;

class TipoSiniestroTable extends Component
{
    public function render()
    {
        $tipos = TipoSiniestro::all();
        return view('livewire.tipo-siniestro-table', compact('tipos'));
    }
} 