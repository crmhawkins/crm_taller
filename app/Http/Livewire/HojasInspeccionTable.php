<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\HojaInspeccion;

class HojasInspeccionTable extends Component
{
    public $cocheId;

    public function mount($cocheId)
    {
        $this->cocheId = $cocheId;
    }

    public function render()
    {
        $hojasInspeccion = HojaInspeccion::where('coche_id', $this->cocheId)->get();

        return view('livewire.hojas-inspeccion-table', compact('hojasInspeccion'));
    }
}
