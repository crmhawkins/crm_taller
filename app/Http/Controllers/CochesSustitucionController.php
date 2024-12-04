<?php

namespace App\Http\Controllers;

use App\Models\CochesSustitucion;
use Illuminate\Http\Request;

class CochesSustitucionController extends Controller
{
    public function index()
    {
        return view('coches-sustitucion.index');
    }

    public function create()
    {
        return view('coches-sustitucion.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'matricula' => 'required|unique:coches_sustitucion',
            'marca' => 'required',
            'modelo' => 'required',
            'kilometraje' => 'required|numeric',
        ]);

        CochesSustitucion::create($request->all());

        return redirect()->route('coches-sustitucion.index')
            ->with('success', 'Coche de sustitución creado correctamente');
    }

    public function edit(CochesSustitucion $cochesSustitucion)
    {
        
        return view('coches-sustitucion.edit', compact('cochesSustitucion'));
    }

    public function update(Request $request, CochesSustitucion $cochesSustitucion)
    {
        $request->validate([
            'matricula' => 'required|unique:coches_sustitucion,matricula,' . $cochesSustitucion->id,
            'marca' => 'required',
            'modelo' => 'required',
            'kilometraje' => 'required|numeric',
        ]);

        $cochesSustitucion->update($request->all());

        return redirect()->route('coches-sustitucion.index')
            ->with('success', 'Coche de sustitución actualizado correctamente');
    }

    public function destroy(CochesSustitucion $cochesSustitucion)
    {
        $cochesSustitucion->delete();

        return redirect()->route('coches-sustitucion.index')
            ->with('success', 'Coche de sustitución eliminado correctamente');
    }
} 