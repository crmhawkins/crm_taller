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

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $siniestros = Siniestro::where('identificador', 'like', '%' . $this->search . '%')
            ->orWhere('poliza', 'like', '%' . $this->search . '%')
            ->paginate(10);

        return view('livewire.siniestro-table', compact('siniestros'));
    }
} 