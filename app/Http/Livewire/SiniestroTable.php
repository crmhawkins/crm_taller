<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Siniestro;

class SiniestroTable extends Component
{
    use WithPagination;

    public $search = '';
    protected $paginationTheme = 'bootstrap';
    public $campo = 'identificador';
    public $fechaInicio;
    public $fechaFin;
    public $coche_id;
    public $cliente_id;

    public function mount($coche_id = null, $cliente_id = null)
    {
        $this->coche_id = $coche_id;
        $this->cliente_id = $cliente_id;
    }

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

    public function render()
    {
        $query = Siniestro::query();

        if ($this->search) {
            $query->where($this->campo, 'like', '%' . $this->search . '%');
        }

        if ($this->fechaInicio && $this->fechaFin) {
            $query->whereBetween('fecha', [$this->fechaInicio, $this->fechaFin]);
        }

        if ($this->coche_id) {
            $query->where('coche_id', $this->coche_id);
        }

        if ($this->cliente_id) {
            $query->where('cliente_id', $this->cliente_id);
        }

        $siniestros = $query->paginate(10);

        return view('livewire.siniestro-table', compact('siniestros'));
    }
} 