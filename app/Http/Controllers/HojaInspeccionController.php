<?php

namespace App\Http\Controllers;

use App\Models\HojaInspeccion;
use App\Models\Coches;
use Illuminate\Http\Request;

class HojaInspeccionController extends Controller
{
    public function index($cocheId)
    {
        $coche = Coches::findOrFail($cocheId);
        $hojasInspeccion = HojaInspeccion::where('coche_id', $cocheId)->get();

        return view('hojas_inspeccion.index', compact('coche', 'hojasInspeccion'));
    }

    public function create($cocheId)
    {
        $coche = Coches::findOrFail($cocheId);
        return view('hojas_inspeccion.create', compact('coche'));
    }

    public function store(Request $request, $cocheId)
    {
        $request->validate([
            'fecha' => 'required|date',
            'matricula' => 'required|string',
            // Añade aquí las validaciones para los demás campos
        ]);

        $data = $request->all();
        $data['coche_id'] = $cocheId;

        //return $data;

        HojaInspeccion::create($data);

        return redirect()->route('hojas_inspeccion.index', $cocheId)
                         ->with('success', 'Hoja de inspección creada con éxito.');
    }

    public function edit($cocheId, $hojaId)
    {
        $coche = Coches::findOrFail($cocheId);
        $hojaInspeccion = HojaInspeccion::findOrFail($hojaId);

        return view('hojas_inspeccion.edit', compact('coche', 'hojaInspeccion'));
    }

    public function update(Request $request, $cocheId, $hojaId)
    {
        $request->validate([
            'fecha' => 'required|date',
            'matricula' => 'required|string',
            // Añade aquí las validaciones para los demás campos
        ]);

        $hojaInspeccion = HojaInspeccion::findOrFail($hojaId);
        $hojaInspeccion->update($request->all());

        return redirect()->route('hojas_inspeccion.index', $cocheId)
                         ->with('success', 'Hoja de inspección actualizada con éxito.');
    }

    public function destroy($cocheId, $hojaId)
    {
        $hojaInspeccion = HojaInspeccion::findOrFail($hojaId);
        $hojaInspeccion->delete();

        return redirect()->route('hojas_inspeccion.index', $cocheId)
                         ->with('success', 'Hoja de inspección borrada con éxito.');
    }
}
