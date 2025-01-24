<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\VisitaCoche;
use App\Models\Coches;

class VisitaCocheController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $visitas = VisitaCoche::paginate(10);
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
        // dd($request->all());
        $validatedData = $request->validate([
            'coche_id' => 'required|exists:coches,id',
            'fecha_ingreso' => 'nullable|date',
            'fecha_salida' => 'nullable|date',
            'kilometraje' => 'nullable|integer',
            'color' => 'nullable|string',
            'ingreso_grua' => 'nullable|boolean',
            'trabajo_a_realizar' => 'nullable|string',
            'observaciones' => 'nullable|string',
            'airbag' => 'nullable|boolean',
            'motor' => 'nullable|boolean',
            'abs' => 'nullable|boolean',
            'aceite' => 'nullable|boolean',
            'bateria' => 'nullable|boolean',
            'cinturon' => 'nullable|boolean',
            'parking' => 'nullable|boolean',
            'luces' => 'nullable|boolean',
            'neumaticos' => 'nullable|boolean',
            'temperatura' => 'nullable|boolean',
            'gato' => 'nullable|boolean',
            'herramientas' => 'nullable|boolean',
            'triangulos' => 'nullable|boolean',
            'tapas' => 'nullable|boolean',
            'llanta' => 'nullable|boolean',
            'extintor' => 'nullable|boolean',
            'antena' => 'nullable|boolean',
            'emblemas' => 'nullable|boolean',
            'tapones' => 'nullable|boolean',
            'cables' => 'nullable|boolean',
            'radio' => 'nullable|boolean',
            'encendedor' => 'nullable|boolean',
            'nivel_gasolina' => 'nullable',
            'foto_daños' => 'nullable|string',
        ]);

        // dd($request->all());


        // dd($validatedData);

        //dd($validatedData);

        VisitaCoche::create($validatedData);

        return redirect()->route('visitas.index')->with('success', 'Visita creada con éxito.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $visita = VisitaCoche::find($id);
        $coches = Coches::all();
        return view('visitas.edit', compact('visita', 'coches'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $visita = VisitaCoche::find($id);
        $visita->update($request->all());
        return redirect()->route('visitas.edit', $id)->with('success', 'Visita actualizada con éxito.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $visita = VisitaCoche::find($id);
        $visita->delete();
        return redirect()->route('visitas.index')->with('success', 'Visita eliminada con éxito.');
    }
}
