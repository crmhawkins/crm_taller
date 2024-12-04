<?php

namespace App\Http\Controllers;

use App\Models\Piezas;
use App\Models\CategoriasPiezas;
use App\Models\Suppliers\Supplier;
use Illuminate\Http\Request;

class PiezasController extends Controller
{
    public function index(Request $request)
    {
        $query = Piezas::query();

        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where('nombre', 'like', "%{$search}%")
                  ->orWhere('codigo', 'like', "%{$search}%")
                  ->orWhere('fabricante', 'like', "%{$search}%");
        }

        $piezas = $query->paginate(10);

        return view('piezas.index', compact('piezas'));
    }

    public function create()
    {
        $categorias = CategoriasPiezas::all();
        $proveedores = Supplier::all();
        return view('piezas.create', compact('categorias', 'proveedores'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'codigo' => 'required|string|max:255',
            'fabricante' => 'nullable|string|max:255',
            'foto' => 'nullable|image',
            'marca' => 'nullable|string|max:255',
            'modelo' => 'nullable|string|max:255',
            'descripcion' => 'nullable|string',
            'nota' => 'nullable|string',
            'proveedor_id' => 'nullable|exists:suppliers,id',
            'numero_serie' => 'nullable|string|max:255',
            'categoria_id' => 'nullable|exists:categorias_piezas,id',
        ]);

        $data = $request->all();

        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('piezas', 'public');
        }

        Piezas::create($data);

        return redirect()->route('piezas.index')->with('success', 'Pieza creada exitosamente.');
    }

    public function show(Piezas $pieza)
    {
        return view('piezas.show', compact('pieza'));
    }

    public function edit(Piezas $pieza)
    {
        $categorias = CategoriasPiezas::all();
        $proveedores = Supplier::all();
        return view('piezas.edit', compact('pieza', 'categorias', 'proveedores'));
    }

    public function update(Request $request, Piezas $pieza)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'codigo' => 'required|string|max:255',
            'fabricante' => 'nullable|string|max:255',
            'foto' => 'nullable|image',
            'marca' => 'nullable|string|max:255',
            'modelo' => 'nullable|string|max:255',
            'descripcion' => 'nullable|string',
            'nota' => 'nullable|string',
            'proveedor_id' => 'nullable|exists:suppliers,id',
            'numero_serie' => 'nullable|string|max:255',
            'categoria_id' => 'nullable|exists:categorias_piezas,id',
        ]);

        $data = $request->all();

        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('piezas', 'public');
        }

        $pieza->update($data);

        return redirect()->route('piezas.index')->with('success', 'Pieza actualizada exitosamente.');
    }

    public function destroy(Piezas $pieza)
    {
        $pieza->delete();

        return redirect()->route('piezas.index')->with('success', 'Pieza eliminada exitosamente.');
    }
}
