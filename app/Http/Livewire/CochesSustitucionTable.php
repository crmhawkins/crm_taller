<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\CochesSustitucion;

class CochesSustitucionTable extends Component
{
    use WithPagination;

    public $search = '';
    public $campo = 'matricula';
    protected $paginationTheme = 'bootstrap';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $coches = CochesSustitucion::query();

        if ($this->search !== '') {
            switch ($this->campo) {
                case 'matricula':
                    $coches->where('matricula', 'like', '%' . $this->search . '%');
                    break;
                case 'marca':
                    $coches->where('marca', 'like', '%' . $this->search . '%');
                    break;
                case 'modelo':
                    $coches->where('modelo', 'like', '%' . $this->search . '%');
                    break;
            }
        }

        return view('livewire.coches-sustitucion-table', [
            'coches' => $coches->paginate(10)
        ]);
    }
} 