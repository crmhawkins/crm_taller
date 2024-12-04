<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Seguro;

class SeguroTable extends Component
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
        $seguros = Seguro::where('identificador', 'like', '%' . $this->search . '%')
            ->orWhere('aseguradora', 'like', '%' . $this->search . '%')
            ->orWhere('responsable', 'like', '%' . $this->search . '%')
            ->paginate(10);

        return view('livewire.seguro-table', compact('seguros'));
    }
} 