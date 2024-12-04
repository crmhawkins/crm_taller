<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Coches;

class CochesTable extends Component
{
    use WithPagination;

    public $search = '';

    protected $paginationTheme = 'bootstrap'; // Opcional: para usar estilos de Bootstrap

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $coches = Coches::where('matricula', 'like', '%' . $this->search . '%')
                        ->orWhere('modelo', 'like', '%' . $this->search . '%')
                        ->paginate(10);

        return view('livewire.coches-table', compact('coches'));
    }
}
