<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Piezas;
use App\Models\CategoriasPiezas;

class PiezasTable extends Component
{
    use WithPagination;

    public $search = '';
    public $categoria_id = '';

    protected $paginationTheme = 'bootstrap';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingCategoriaId()
    {
        $this->resetPage();
    }

    public function render()
    {
        $categorias = CategoriasPiezas::all();

        $piezas = Piezas::query()
            ->when($this->categoria_id, function($query) {
                $query->where('categoria_id', $this->categoria_id);
            })
            ->where(function($query) {
                $query->where('nombre', 'like', '%' . $this->search . '%')
                      ->orWhere('codigo', 'like', '%' . $this->search . '%')
                      ->orWhere('fabricante', 'like', '%' . $this->search . '%');
            })
            ->paginate(10);

        return view('livewire.piezas-table', compact('piezas', 'categorias'));
    }
}
