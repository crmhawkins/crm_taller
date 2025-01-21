<?php

namespace App\Http\Controllers;

use App\Models\Siniestro;
use App\Models\Seguro;
use App\Models\TipoSiniestro;
use App\Models\EstadoSiniestro;
use App\Models\Coches;
use App\Models\Clients\Client;
use Illuminate\Http\Request;
use App\Models\Alerts\Alert;
use App\Models\Users\User;
use Carbon\Carbon;

class SiniestroController extends Controller
{
    public function index()
    {
        return view('siniestro.index');
    }

    public function create(Request $request)
    {
        $seguros = Seguro::all();
        $tiposSiniestro = TipoSiniestro::all();
        $estadosSiniestro = EstadoSiniestro::all();
        $coches = Coches::all();
        $clientes = Client::all();

        $cocheId = $request->query('coche_id');
        $clienteId = $request->query('cliente_id');
        return view('siniestro.create', compact('seguros', 'tiposSiniestro', 'estadosSiniestro', 'coches', 'clientes', 'cocheId', 'clienteId'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'identificador' => 'nullable|string|max:255',
            'fecha' => 'nullable|date',
            'poliza' => 'nullable|string|max:255',
            'coche_id' => 'nullable|integer',
            'cliente_id' => 'nullable|integer',
            'descripcion' => 'nullable|string',
            'daños' => 'nullable|string',
            'coste_reparacion' => 'nullable|numeric',
            'inicio_reparacion' => 'nullable|date',
            'fin_reparacion' => 'nullable|date',
            'monto_aseguradora' => 'nullable|numeric',
            'monto_cliente' => 'nullable|numeric',
            'comentarios' => 'nullable|string',
            'prioridad' => 'nullable|string|max:255',
            'tipo_siniestro_id' => 'nullable|integer',
            'estado_siniestro_id' => 'nullable|integer',
            'seguro_id' => 'nullable|integer',
            'peritaje' => 'nullable|boolean',
            'peritaje_externo' => 'nullable|boolean',
        ]);

        $siniestro = Siniestro::create($request->all());
        if ($request->file('imagenes')) {
            foreach ($request->file('imagenes') as $imagen) {
                $siniestro->addMedia($imagen)->toMediaCollection('imagenes');
            }
        }
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
            'identificador' => 'nullable|string|max:255',
            'fecha' => 'nullable|date',
            'poliza' => 'nullable|string|max:255',
            'coche_id' => 'nullable|integer',
            'cliente_id' => 'nullable|integer',
            'descripcion' => 'nullable|string',
            'daños' => 'nullable|string',
            'coste_reparacion' => 'nullable|numeric',
            'inicio_reparacion' => 'nullable|date',
            'fin_reparacion' => 'nullable|date',
            'monto_aseguradora' => 'nullable|numeric',
            'monto_cliente' => 'nullable|numeric',
            'comentarios' => 'nullable|string',
            'prioridad' => 'nullable|string|max:255',
            'tipo_siniestro_id' => 'nullable|integer',
            'estado_siniestro_id' => 'nullable|integer',
            'seguro_id' => 'nullable|integer',
            'peritaje' => 'nullable|boolean',
            'peritaje_externo' => 'nullable|boolean',
        ]);

        // Comprobar si el estado_siniestro_id va a cambiar
    if ($siniestro->estado_siniestro_id != $request->estado_siniestro_id) {
        $estado = EstadoSiniestro::find($request->estado_siniestro_id);
        $mensaje = "El estado del siniestro con ID {$siniestro->id} ha cambiado. Nuevo estado: " . ($estado ? $estado->estado : 'No se encontró el estado');        
        // Obtener todos los usuarios activos
        $users = User::where('inactive', 0)->get();

        // Crear una alerta para cada usuario activo
        foreach ($users as $usuario) {
            Alert::create([
                'admin_user_id' => $usuario->id,
                'stage_id' => 32,
                'activation_datetime' => Carbon::now(),
                'status_id' => 1,
                'reference_id' => $siniestro->id,
                'description' => $mensaje
            ]);
        }
    }

        $siniestro->update($request->all());

        if ($request->file('imagenes')) {
            foreach ($request->file('imagenes') as $imagen) {
                $siniestro->addMedia($imagen)->toMediaCollection('imagenes');
            }
        }

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