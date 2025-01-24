<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\VisitaCoche;

class VisitasTable extends Component
{
    use WithPagination;

    public $search = '';
    public $cocheId;
    public $fechaInicio;
    public $fechaFin;

    protected $paginationTheme = 'bootstrap';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingFechaInicio()
    {
        $this->resetPage();
    }

    public function updatingFechaFin()
    {
        $this->resetPage();
    }

    public function mount($cocheId = null)
    {
        $this->cocheId = $cocheId;
    }

    public function render()
    {
        $query = VisitaCoche::query();

        if ($this->cocheId) {
            $query->where('coche_id', $this->cocheId);
        }

        if ($this->search) {
            $query->whereHas('coche', function($q) {
                $q->where('matricula', 'like', '%' . $this->search . '%');
            });
        }

        if ($this->fechaInicio && $this->fechaFin) {
            $query->whereBetween('fecha_ingreso', [$this->fechaInicio, $this->fechaFin]);
        }

        $visitasCoche = $query->paginate(10);
        //dd($visitas);

        return view('livewire.visitas-table', compact('visitasCoche'));
    }
}
