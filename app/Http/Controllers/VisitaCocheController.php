<?php

namespace App\Http\Controllers;

use App\Models\VisitaCoche;
use App\Models\Coches;
use Illuminate\Http\Request;

class VisitaCocheController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $visitas = VisitaCoche::all();
        return view('visitas.index', compact('visitas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $coches = Coches::all();
        return view('visitas.create', compact('coches'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'coche_id' => 'required|exists:coches,id',
            'fecha_ingreso' => 'nullable|date',
            'fecha_salida' => 'nullable|date',
            'kilometraje' => 'nullable|integer',
            'color' => 'nullable|string',
            // Añade validaciones para los demás campos según sea necesario
        ]);

        VisitaCoche::create($validatedData);

        return redirect()->route('visitas.index')->with('success', 'Visita creada con éxito.');
    }

    /**
     * Display the specified resource.
     */
    public function show(VisitaCoche $visitaCoche)
    {
        return view('visitas.show', compact('visitaCoche'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(VisitaCoche $visitaCoche)
    {
        return view('visitas.edit', compact('visitaCoche'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, VisitaCoche $visitaCoche)
    {
        $validatedData = $request->validate([
            'coche_id' => 'required|exists:coches,id',
            'fecha_ingreso' => 'nullable|date',
            'fecha_salida' => 'nullable|date',
            'kilometraje' => 'nullable|integer',
            'color' => 'nullable|string',
            // Añade validaciones para los demás campos según sea necesario
        ]);

        $visitaCoche->update($validatedData);

        return redirect()->route('visitas.index')->with('success', 'Visita actualizada con éxito.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(VisitaCoche $visitaCoche)
    {
        $visitaCoche->delete();

        return redirect()->route('visitas.index')->with('success', 'Visita eliminada con éxito.');
    }
}
