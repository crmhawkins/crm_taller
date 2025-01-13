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

        if ($request->has('firma_cliente')) {
            $image = $request->input('firma_cliente'); // base64 encoded image
            $image = str_replace('data:image/png;base64,', '', $image);
            $image = str_replace(' ', '+', $image);
            $imageName = 'firma_' . time() . '.png';
            \File::put(public_path('firmas') . '/' . $imageName, base64_decode($image));
            $data['firma_cliente'] = $imageName;
        }

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
}
