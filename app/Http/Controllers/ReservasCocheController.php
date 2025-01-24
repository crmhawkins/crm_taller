<?php

namespace App\Http\Controllers;

use App\Models\ReservasCoche;
use App\Models\CochesSustitucion;
use App\Models\Clients\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ReservasCocheController extends Controller
{
    public function index()
    {
        try {
            return view('reservas-coche.index');
        } catch (\Exception $e) {
            Log::error('Error al mostrar el listado de reservas: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Ha ocurrido un error al cargar la página');
        }
    }

    public function create()
    {
        try {
            $coches = CochesSustitucion::all()->filter(function ($coche) {
                return $coche->isDisponible();
            });
            $clientes = Client::all();
            return view('reservas-coche.create', compact('coches', 'clientes'));
        } catch (\Exception $e) {
            Log::error('Error al mostrar el formulario de creación: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Ha ocurrido un error al cargar el formulario');
        }
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'coche_sustitucion_id' => 'required|exists:coches_sustitucion,id',
                'cliente_id' => 'required|exists:clients,id',
                'fecha_inicio' => 'required|date',
                'fecha_fin' => 'nullable|date|after_or_equal:fecha_inicio',
                'estado' => 'required|string|max:20',
                'comentario' => 'nullable|string|max:255',
                'km_actual' => 'required|integer',
                'km_entregado' => 'nullable|integer',
            ],
            [
                'coche_sustitucion_id.required' => 'El coche sustitución es obligatorio.',
                'coche_sustitucion_id.exists' => 'El coche sustitución seleccionado no es válido.',
                'cliente_id.required' => 'El cliente es obligatorio.',
                'cliente_id.exists' => 'El cliente seleccionado no es válido.',
                'fecha_inicio.required' => 'La fecha de inicio es obligatoria.',
                'fecha_inicio.date' => 'La fecha de inicio debe ser una fecha válida.',
                'fecha_fin.date' => 'La fecha de fin debe ser una fecha válida.',
                'fecha_fin.after_or_equal' => 'La fecha de fin debe ser igual o posterior a la fecha de inicio.',
            ]
            
            )
            
            ;

            ReservasCoche::create($validated);

            return redirect()->route('reservas-coche.index')
                ->with('success', 'Reserva creada correctamente');

        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()
                ->withErrors($e->validator)
                ->withInput();
        } catch (\Exception $e) {
            Log::error('Error al crear reserva: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'Ha ocurrido un error al crear la reserva')
                ->withInput();
        }
    }

    public function edit( $id)
    {
        try {
            $reservasCoche = ReservasCoche::find($id);
            $coches = CochesSustitucion::all();
            $clientes = Client::all();
            return view('reservas-coche.edit', compact('reservasCoche', 'coches', 'clientes'));
        } catch (\Exception $e) {
            Log::error('Error al mostrar el formulario de edición: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Ha ocurrido un error al cargar el formulario de edición');
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $validated = $request->validate([
                'coche_sustitucion_id' => 'required|exists:coches_sustitucion,id',
                'cliente_id' => 'required|exists:clients,id',
                'fecha_inicio' => 'required|date',
                'fecha_fin' => 'nullable|date|after_or_equal:fecha_inicio',
                'estado' => 'required|string|max:20',
                'comentario' => 'nullable|string|max:255',
                'km_actual' => 'nullable|integer',
                'km_entregado' => 'nullable|integer',
            ]);

            $reservasCoche = ReservasCoche::find($id);
            $reservasCoche->update($validated);

            return redirect()->route('reservas-coche.index')
                ->with('success', 'Reserva actualizada correctamente');

        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()
                ->withErrors($e->validator)
                ->withInput();
        } catch (\Exception $e) {
            Log::error('Error al actualizar reserva: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'Ha ocurrido un error al actualizar la reserva')
                ->withInput();
        }
    }

    public function destroy($id)
    {
        try {
            $reservasCoche = ReservasCoche::find($id);
            $reservasCoche->delete();
            return redirect()->route('reservas-coche.index')
                ->with('success', 'Reserva eliminada correctamente');
        } catch (\Exception $e) {
            Log::error('Error al eliminar reserva: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'Ha ocurrido un error al eliminar la reserva');
        }
    }
} 