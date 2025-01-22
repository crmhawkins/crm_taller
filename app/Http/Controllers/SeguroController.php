<?php

namespace App\Http\Controllers;

use App\Models\Seguro;
use Illuminate\Http\Request;

class SeguroController extends Controller
{
    public function index()
    {
        $seguros = Seguro::all();
        return view('seguro.index', compact('seguros'));
    }

    public function create()
    {
        return view('seguro.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'identificador' => 'required|string|max:255',
            'aseguradora' => 'required|string|max:255',
            'responsable' => 'nullable|string|max:255',
            'telefono' => 'nullable|string|max:20',
            'notas' => 'nullable|string',
            'precio' => 'required|numeric',
        ]);

        Seguro::create($request->all());

        return redirect()->route('seguro.index')
                         ->with('success', 'Seguro creado exitosamente.');
    }

    public function show(Seguro $seguro)
    {
        return view('seguro.show', compact('seguro'));
    }

    public function edit($id)
    {
        $seguro = Seguro::findOrFail($id);
        return view('seguro.edit', compact('seguro'));
    }

    public function update(Request $request, $id)
    {
        $seguro = Seguro::findOrFail($id);

        $request->validate([
            'identificador' => 'required|string|max:255',
            'aseguradora' => 'required|string|max:255',
            'responsable' => 'nullable|string|max:255',
            'telefono' => 'nullable|string|max:20',
            'notas' => 'nullable|string',
            'precio' => 'required|numeric',
        ]);

        $seguro->update($request->all());

        return redirect()->route('seguro.index')
                         ->with('success', 'Seguro actualizado exitosamente.');
    }

    public function destroy($id)
    {
        $seguro = Seguro::findOrFail($id);
        $seguro->delete();

        return redirect()->route('seguro.index')
                         ->with('success', 'Seguro eliminado exitosamente.');
    }
} 