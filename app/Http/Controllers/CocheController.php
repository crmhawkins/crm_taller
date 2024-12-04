<?php

namespace App\Http\Controllers;

use App\Models\Coches;
use Illuminate\Http\Request;

class CocheController extends Controller
{
    public function index()
    {
        $coches = Coches::all();
        return view('coches.index', compact('coches'));
    }

    public function create()
    {
        $clientes = \App\Models\Clients\Client::all(); // Asegúrate de usar el namespace correcto para el modelo Client
        return view('coches.create', compact('clientes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'matricula' => 'required|unique:coches',
            'seguro' => 'nullable|string',
            'marca' => 'nullable|string',
            'vin' => 'nullable|string',
            'modelo' => 'nullable|string',
            'kilometraje' => 'nullable|integer',
            'color' => 'nullable|string',
            'anio' => 'nullable|integer',
            'cliente_id' => 'nullable|exists:clients,id',
        ]);

        Coches::create($request->all());

        return redirect()->route('coches.index')->with('success', 'Coche creado exitosamente.');
    }

    public function show(Coches $coche)
    {
        return view('coches.show', compact('coche'));
    }

    public function edit(Coches $coche)
    {
        $clientes = \App\Models\Clients\Client::all();
        return view('coches.edit', compact('coche', 'clientes'));
    }

    public function update(Request $request, Coches $coche)
    {
        $request->validate([
            'matricula' => 'required|unique:coches,matricula,' . $coche->id,
            'seguro' => 'nullable|string',
            'marca' => 'nullable|string',
            'vin' => 'nullable|string',
            'modelo' => 'nullable|string',
            'kilometraje' => 'nullable|integer',
            'color' => 'nullable|string',
            'anio' => 'nullable|integer',
            'cliente_id' => 'nullable|exists:clients,id',
        ]);

        $coche->update($request->all());

        return redirect()->route('coches.index')->with('success', 'Coche actualizado exitosamente.');
    }

    public function destroy(Coches $coche)
    {
        $coche->delete();

        return redirect()->route('coches.index')->with('success', 'Coche eliminado exitosamente.');
    }
}
