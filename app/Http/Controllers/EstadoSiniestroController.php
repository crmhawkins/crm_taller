<?php

namespace App\Http\Controllers;

use App\Models\EstadoSiniestro;
use Illuminate\Http\Request;

class EstadoSiniestroController extends Controller
{
    public function index()
    {
        $estados = EstadoSiniestro::all();
        return view('estado-siniestro.index', compact('estados'));
    }

    public function create()
    {
        return view('estado-siniestro.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'estado' => 'required|string|max:255',
        ]);

        EstadoSiniestro::create($request->all());

        return redirect()->route('estado-siniestro.index')
                         ->with('success', 'Estado de Siniestro creado exitosamente.');
    }

    public function show(EstadoSiniestro $estadoSiniestro)
    {
        return view('estado-siniestro.show', compact('estadoSiniestro'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
{
    $estadoSiniestro = EstadoSiniestro::findOrFail($id); // Cambiado a findOrFail para manejar errores
    return view('estado-siniestro.edit', compact('estadoSiniestro'));
}

public function update(Request $request, EstadoSiniestro $estadoSiniestro)
{
    $request->validate([
        'estado' => 'required|string|max:255',
    ]);

    dd($estadoSiniestro);

    $estadoSiniestro->update([
        'estado' => $request->estado,
    ]); // Asegúrate de que solo se actualicen los campos necesarios
    dd($estadoSiniestro);
    return redirect()->route('estado-siniestro.index')
                     ->with('success', 'Estado de Siniestro actualizado exitosamente.');
}

    public function destroy(EstadoSiniestro $estadoSiniestro)
    {
        $estadoSiniestro->delete();

        return redirect()->route('estado-siniestro.index')
                         ->with('success', 'Estado de Siniestro eliminado exitosamente.');
    }
}
