<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\ReservasCoche;
use App\Models\CochesSustitucion;
use Carbon\Carbon;

class ReservasCocheTable extends Component
{
    use WithPagination;

    public $search = '';
    public $campo = 'fecha_inicio';
    public $fechaInicio;
    public $fechaFin;
    protected $paginationTheme = 'bootstrap';
    public $searchCoches = ''; // Nueva propiedad para el buscador de coches

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingSearchCoches()
    {
        $this->resetPage();
    }

    public function render()
    {
        $reservas = ReservasCoche::query();

        if ($this->search !== '') {
            switch ($this->campo) {
                case 'estado':
                    $reservas->where('estado', 'like', '%' . $this->search . '%');
                    break;
                case 'cliente':
                    $reservas->whereHas('cliente', function($query) {
                        $query->where('name', 'like', '%' . $this->search . '%')
                              ->orWhere('lastname', 'like', '%' . $this->search . '%');
                    });
                    break;
                case 'coche':
                    $reservas->whereHas('coche', function($query) {
                        $query->where('matricula', 'like', '%' . $this->search . '%');
                    });
                    break;
            }
        }

        // Filtrar por superposición de fechas
        if (!empty($this->fechaInicio) && !empty($this->fechaFin)) {
            $reservas->where(function($query) {
                $query->whereBetween('fecha_inicio', [$this->fechaInicio, $this->fechaFin])
                      ->orWhereBetween('fecha_fin', [$this->fechaInicio, $this->fechaFin])
                      ->orWhere(function($query) {
                          $query->where('fecha_inicio', '<=', $this->fechaInicio)
                                ->where('fecha_fin', '>=', $this->fechaFin);
                      });
            });

            // Obtener coches reservados
            $cochesReservados = ReservasCoche::where(function($query) {
                $query->whereBetween('fecha_inicio', [$this->fechaInicio, $this->fechaFin])
                      ->orWhereBetween('fecha_fin', [$this->fechaInicio, $this->fechaFin])
                      ->orWhere(function($query) {
                          $query->where('fecha_inicio', '<=', $this->fechaInicio)
                                ->where('fecha_fin', '>=', $this->fechaFin);
                      });
            })->pluck('coche_sustitucion_id');

            $cochesDisponibles = CochesSustitucion::whereNotIn('id', $cochesReservados)
                ->where(function($query) {
                    $query->where('matricula', 'like', '%' . $this->searchCoches . '%')
                          ->orWhere('marca', 'like', '%' . $this->searchCoches . '%')
                          ->orWhere('modelo', 'like', '%' . $this->searchCoches . '%');
                })
                ->paginate(10); // Añadir paginación
        } else {
            $cochesDisponibles = CochesSustitucion::where(function($query) {
                $query->where('matricula', 'like', '%' . $this->searchCoches . '%')
                      ->orWhere('marca', 'like', '%' . $this->searchCoches . '%')
                      ->orWhere('modelo', 'like', '%' . $this->searchCoches . '%');
            })
            ->paginate(10); // Añadir paginación
        }

        return view('livewire.reservas-coche-table', [
            'reservas' => $reservas->paginate(10),
            'cochesDisponibles' => $cochesDisponibles
        ]);
    }
} 