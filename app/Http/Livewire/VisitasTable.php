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

    protected $paginationTheme = 'bootstrap';

    public function updatingSearch()
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
            $query->where(function($q) {
                $q->where('coche_id', 'like', '%' . $this->search . '%')
                  ->orWhere('fecha_ingreso', 'like', '%' . $this->search . '%');
            });
        }

        $visitas = $query->paginate(10);

        return view('livewire.visitas-table', compact('visitas'));
    }
}
