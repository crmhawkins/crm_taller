<?php

namespace App\Http\Controllers;

use App\Models\CategoriasPiezas;
use Illuminate\Http\Request;

class CategoriasPiezasController extends Controller
{
    public function index()
    {
        $categorias = CategoriasPiezas::all();
        return view('categorias_piezas.index', compact('categorias'));
    }

    public function create()
    {
        return view('categorias_piezas.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
        ]);

        CategoriasPiezas::create($request->all());

        return redirect()->route('categorias-piezas.index')->with('success', 'Categoría creada exitosamente.');
    }

    public function show(CategoriasPiezas $categoria)
    {
        return view('categorias_piezas.show', compact('categoria'));
    }

    public function edit(CategoriasPiezas $categoria)
    {
        return view('categorias_piezas.edit', compact('categoria'));
    }

    public function update(Request $request, CategoriasPiezas $categoria)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
        ]);

        $categoria->update($request->all());

        return redirect()->route('categorias-piezas.index')->with('success', 'Categoría actualizada exitosamente.');
    }

    public function destroy(CategoriasPiezas $categoria)
    {
        $categoria->delete();

        return redirect()->route('categorias-piezas.index')->with('success', 'Categoría eliminada exitosamente.');
    }
}
