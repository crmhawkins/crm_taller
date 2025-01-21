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

    public function render()
    {
        $siniestros = Siniestro::query();

        if ($this->fechaInicio) {
            $siniestros->whereDate('fecha', '>=', $this->fechaInicio);
        }
        if ($this->fechaFin) {
            $siniestros->whereDate('fecha', '<=', $this->fechaFin);
        }

        if ($this->coche_id) {
            $siniestros->where('coche_id', $this->coche_id);
        }

        if ($this->cliente_id) {
            $siniestros->where('cliente_id', $this->cliente_id);
        }

        if ($this->search !== '') {
            switch ($this->campo) {
                case 'identificador':
                    $siniestros->where('identificador', 'like', '%' . $this->search . '%');
                    break;
                case 'seguro':
                    $siniestros->whereHas('seguro', function($query) {
                        $query->where('aseguradora', 'like', '%' . $this->search . '%');
                    });
                    break;
                case 'cliente':
                    $siniestros->whereHas('cliente', function($query) {
                        $query->where('name', 'like', '%' . $this->search . '%');
                    });
                    break;
                case 'matricula':
                    $siniestros->whereHas('coche', function($query) {
                        $query->where('matricula', 'like', '%' . $this->search . '%');
                    });
                    break;
                case 'prioridad':
                    $siniestros->where('prioridad', 'like', '%' . $this->search . '%');
                    break;
            }
        }

        return view('livewire.siniestro-table', [
            'siniestros' => $siniestros->paginate(10)
        ]);
    }
} 