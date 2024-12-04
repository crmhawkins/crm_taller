<?php

namespace App\Http\Controllers;

use App\Models\TipoSiniestro;
use Illuminate\Http\Request;

class TipoSiniestroController extends Controller
{
    public function index()
    {
        $tipos = TipoSiniestro::all();
        return view('tipo-siniestro.index', compact('tipos'));
    }

    public function create()
    {
        return view('tipo-siniestro.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'tipo' => 'required|string|max:255',
        ]);

        TipoSiniestro::create($request->all());

        return redirect()->route('tipo-siniestro.index')
                         ->with('success', 'Tipo de Siniestro creado exitosamente.');
    }

    public function show(TipoSiniestro $tipoSiniestro)
    {
        return view('tipo-siniestro.show', compact('tipoSiniestro'));
    }

    public function edit($id)
    {
        $tipoSiniestro = TipoSiniestro::findOrFail($id);
        return view('tipo-siniestro.edit', compact('tipoSiniestro'));
    }

    public function update(Request $request, $id)
    {
        $tipoSiniestro = TipoSiniestro::findOrFail($id);

        $request->validate([
            'tipo' => 'required|string|max:255',
        ]);

        $tipoSiniestro->update([
            'tipo' => $request->tipo,
        ]);

        return redirect()->route('tipo-siniestro.index')
                         ->with('success', 'Tipo de Siniestro actualizado exitosamente.');
    }

    public function destroy($id)
    {
        $tipoSiniestro = TipoSiniestro::findOrFail($id);
        $tipoSiniestro->delete();

        return redirect()->route('tipo-siniestro.index')
                         ->with('success', 'Tipo de Siniestro eliminado exitosamente.');
    }
}
