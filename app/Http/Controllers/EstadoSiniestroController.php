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
        //dd($id); // Verifica si el ID recibido es el correcto
        $estadoSiniestro = EstadoSiniestro::findOrFail($id);
        //dd($estadoSiniestro);
        return view('estado-siniestro.edit', compact('estadoSiniestro'));
    }
    
    public function update(Request $request, $id)
{
    // Aquí utilizamos findOrFail para asegurarnos de que el modelo se encuentra
    $estadoSiniestro = EstadoSiniestro::findOrFail($id);

    // Validación de los datos
    $request->validate([
        'estado' => 'required|string|max:255',
    ]);

    // Actualizamos el estado del siniestro
    $estadoSiniestro->update([
        'estado' => $request->estado,
    ]);

    return redirect()->route('estado-siniestro.index')
                     ->with('success', 'Estado de Siniestro actualizado exitosamente.');
}

    public function destroy($id)
    {
        // Recuperar el modelo de EstadoSiniestro por su ID
        $estadoSiniestro = EstadoSiniestro::findOrFail($id);

        // Eliminar el modelo de forma blanda (SoftDelete)
        $estadoSiniestro->delete();

        // Redirigir con mensaje de éxito
        return redirect()->route('estado-siniestro.index')
                        ->with('success', 'Estado de Siniestro eliminado exitosamente.');
    }
}
