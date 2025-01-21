<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\VisitaCoche;

class VisitasTable extends Component
{
    use WithPagination;

    public $search = '';

    protected $paginationTheme = 'bootstrap';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $visitas = VisitaCoche::where('coche_id', 'like', '%' . $this->search . '%')
            ->orWhere('fecha_ingreso', 'like', '%' . $this->search . '%')
            ->paginate(10);

        return view('livewire.visitas-table', compact('visitas'));
    }
}
