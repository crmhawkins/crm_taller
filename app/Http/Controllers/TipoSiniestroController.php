<?php

namespace App\Http\Controllers;

use App\Models\TipoSiniestro;
use Illuminate\Http\Request;

class TipoSiniestroController extends Controller
{
    public function index()
    {
        $tipos = TipoSiniestro::all();
        return view('tipo_siniestro.index', compact('tipos'));
    }

    public function create()
    {
        return view('tipo_siniestro.create');
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

    // Implementar los otros métodos: show, edit, update, destroy
}
