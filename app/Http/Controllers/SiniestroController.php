<?php

namespace App\Http\Controllers;

use App\Models\Siniestro;
use App\Models\Seguro;
use App\Models\TipoSiniestro;
use App\Models\EstadoSiniestro;
use App\Models\Coches;
use App\Models\Clients\Client;
use Illuminate\Http\Request;


class SiniestroController extends Controller
{
    public function index()
    {
        return view('siniestro.index');
    }

    public function create()
    {
        $seguros = Seguro::all();
        $tiposSiniestro = TipoSiniestro::all();
        $estadosSiniestro = EstadoSiniestro::all();
        $coches = Coches::all();
        $clientes = Client::all();

        return view('siniestro.create', compact('seguros', 'tiposSiniestro', 'estadosSiniestro', 'coches', 'clientes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'identificador' => 'required|string|max:255',
            'fecha' => 'required|date',
            'poliza' => 'required|string|max:255',
            'coche_id' => 'required|integer',
            'cliente_id' => 'required|integer',
            'descripcion' => 'nullable|string',
            'daños' => 'nullable|string',
            'coste_reparacion' => 'nullable|numeric',
            'inicio_reparacion' => 'nullable|date',
            'fin_reparacion' => 'nullable|date',
            'monto_aseguradora' => 'nullable|numeric',
            'monto_cliente' => 'nullable|numeric',
            'comentarios' => 'nullable|string',
            'prioridad' => 'nullable|string|max:255',
            'tipo_siniestro_id' => 'required|integer',
            'estado_siniestro_id' => 'required|integer',
            'seguro_id' => 'required|integer',
        ]);

        Siniestro::create($request->all());

        return redirect()->route('siniestro.index')
                         ->with('success', 'Siniestro creado exitosamente.');
    }

    public function show(Siniestro $siniestro)
    {
        return view('siniestro.show', compact('siniestro'));
    }

    public function edit($id)
    {
        $siniestro = Siniestro::findOrFail($id);
        $seguros = Seguro::all();
        $tiposSiniestro = TipoSiniestro::all();
        $estadosSiniestro = EstadoSiniestro::all();
        $coches = Coches::all();
        $clientes = Client::all();

        return view('siniestro.edit', compact('siniestro', 'seguros', 'tiposSiniestro', 'estadosSiniestro', 'coches', 'clientes'));
    }

    public function update(Request $request, $id)
    {
        $siniestro = Siniestro::findOrFail($id);

        $request->validate([
            'identificador' => 'required|string|max:255',
            'fecha' => 'required|date',
            'poliza' => 'required|string|max:255',
            'coche_id' => 'required|integer',
            'cliente_id' => 'required|integer',
            'descripcion' => 'nullable|string',
            'daños' => 'nullable|string',
            'coste_reparacion' => 'nullable|numeric',
            'inicio_reparacion' => 'nullable|date',
            'fin_reparacion' => 'nullable|date',
            'monto_aseguradora' => 'nullable|numeric',
            'monto_cliente' => 'nullable|numeric',
            'comentarios' => 'nullable|string',
            'prioridad' => 'nullable|string|max:255',
            'tipo_siniestro_id' => 'required|integer',
            'estado_siniestro_id' => 'required|integer',
            'seguro_id' => 'required|integer',
        ]);

        $siniestro->update($request->all());

        return redirect()->route('siniestro.index')
                         ->with('success', 'Siniestro actualizado exitosamente.');
    }

    public function destroy($id)
    {
        $siniestro = Siniestro::findOrFail($id);
        $siniestro->delete();

        return redirect()->route('siniestro.index')
                         ->with('success', 'Siniestro eliminado exitosamente.');
    }
} 