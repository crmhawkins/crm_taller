<?php

namespace App\Http\Controllers\Clients;

use App\Http\Controllers\Controller;
use App\Models\Clients\Client;
use App\Models\Clients\ClientEmail;
use App\Models\Clients\ClientPhone;
use App\Models\Clients\ClientWeb;
use App\Models\Contacts\Contact;
use App\Models\Countries\Country;
use App\Models\Users\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Coches;
use App\Models\ReservasCoche;
use App\Models\CochesSustitucion;
use App\Models\Budgets\Budget;
class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $clientes = Client::where('is_client', 1)->with('coches')->get();
        return view('clients.index', compact('clientes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // $gestores = User::where('access_level_id', 4)->get();
        $gestores = User::all();
        $clientes = Client::all();
        $countries = Country::all();

        return view('clients.create', compact('gestores','clientes','countries'));

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // return $request->all();
        // Validamos los campos
        $this->validate($request, [
            'name' => 'required|max:200',
            'admin_user_id' => 'nullable|exists:admin_user,id',
            'email' => 'required|email:filter',
            'company' => 'nullable|max:200',
            'cif' => 'nullable|max:200',
            'identifier' => 'nullable|max:200',
            'activity' => 'nullable|max:200',
            'address' => 'nullable|max:200',
            'country' => 'nullable|max:200',
            'city' => 'nullable|max:200',
            'province' => 'nullable|max:200',
            'zipcode' => 'nullable|max:200',
            'phone' => 'required',
            'pin' => 'nullable',
        ], [
            'name.required' => 'El nombre es requerido para continuar',
            'admin_user_id.required' => 'El gestor es requerido para continuar',
            'admin_user_id.exists' => 'El gestor debe ser valido para continuar',
            'email.required' => 'El email es requerido para continuar',
            'email.email' => 'El email debe ser un email valido',
            'company.required' => 'El nombre de la empresa a es requerido para continuar',
            'cif.required' => 'El cif es requerido para continuar',
            'identifier.required' => 'La marca es requerida para continuar',
            'activity.required' => 'La actividad es requerida para continuar',
            'address.required' => 'La dirección es requerida para continuar',
            'country.required' => 'El pais es requerido para continuar',
            'city.required' => 'La ciudad es requerida para continuar',
            'province.required' => 'La provincia es requerida para continuar',
            'zipcode.required' => 'El codigo postal es requerido para continuar',
            'phone.required' => 'El telefono es requerido para continuar',
        ]);

        $data = $request->all();
        $data['is_client'] = true;
        $data['is_client'] = true;
        $data['admin_user_id'] = Auth::user()->id;
        $clienteCreado = Client::create($data);
        if($clienteCreado->pin == null){
            $clienteCreado->pin = rand(100000, 999999);
            $clienteCreado->save();
        }
        // dd($clienteCreado);

        // Validamos si hay contacto asociado
        if (isset($data['newAssociatedContact'])) {
            foreach($data['newAssociatedContact'] as $newContacto){
                // dd(Auth::user()->id);
                $newContacto['admin_user_id'] = Auth::user()->id;
                $newContacto['civil_status_id'] = null;
                $newContacto['phone'] = $newContacto['telephone'];
                $newContacto['client_id'] = $clienteCreado->id;
                $newContacto['privacy_policy_accepted'] = false;
                $newContacto['cookies_accepted'] = false;
                $newContacto['newsletters_sending_accepted'] = false;
                // dd($newContacto);
                $contacto = Contact::create($newContacto);
                if (!$contacto) {
                    return session()->flash('toast', [
                        'icon' => 'error',
                        'mensaje' => "Error en el servidor, intentelo mas tarde."
                    ]);
                }
            }
        }

        // Teléfonos
        if($request->input('numbers')){
            foreach($request->input('numbers') as $key => $value) {
                if($value != ''){
                    $clientPhones = ClientPhone::create(['client_id'=> $clienteCreado->id,'number'=>$value]);
                    $clientPhonesSaved = $clientPhones->save();
                    if (!$clientPhonesSaved) {
                        return session()->flash('toast', [
                            'icon' => 'error',
                            'mensaje' => "Error en el servidor, intentelo mas tarde."
                        ]);
                    }
                }
            }
        }
        // Mails
        if($request->input('mails')){
            foreach($request->input('mails') as $key => $value) {
                if($value != ''){
                    $clientMails = ClientEmail::create(['client_id'=> $clienteCreado->id,'email'=>$value]);
                    $clientMailsSaved = $clientMails->save();
                    if (!$clientMailsSaved) {
                        return session()->flash('toast', [
                            'icon' => 'error',
                            'mensaje' => "Error en el servidor, intentelo mas tarde."
                        ]);
                    }
                }
            }
        }

        // Webs
        if($request->input('webs')){
            foreach($request->input('webs') as $key => $value) {
                if($value != ''){
                    // dd($value);
                    $clientWebs = ClientWeb::create(['client_id'=> $clienteCreado->id,'url'=>$value]);
                    $clientWebsSaved = $clientWebs->save();
                    if (!$clientWebsSaved) {
                        return session()->flash('toast', [
                            'icon' => 'error',
                            'mensaje' => "Error en el servidor, intentelo mas tarde."
                        ]);
                    }
                }
            }
        }
        // dd($data);

        session()->flash('toast', [
            'icon' => 'success',
            'mensaje' => 'El cliente se creo correctamente'
        ]);

        return redirect()->route('clientes.show', $clienteCreado->id);
    }


    public function storeFromBudget(Request $request)
    {
        // Validamos los campos
        $this->validate($request, [
            'name' => 'required|max:200',
            'primerApellido' => 'nullable',
            'segundoApellido' => 'nullable',
            'tipoCliente' => 'nullable',
            'admin_user_id' => 'required|exists:admin_user,id',
            'email' => 'required|email:filter',
            'company' => 'nullable|max:200',
            'cif' => 'nullable|max:200',
            'identifier' => 'nullable|max:200',
            'industry' => 'nullable|max:200',
            'activity' => 'nullable|max:200',
            'address' => 'nullable|max:200',
            'country' => 'nullable|max:200',
            'city' => 'nullable|max:200',
            'province' => 'nullable|max:200',
            'zipcode' => 'nullable|max:200',
            'phone' => 'required',
            'pin' => 'nullable',
        ], [
            'name.required' => 'El nombre es requerido para continuar',
            'admin_user_id.required' => 'El gestor es requerido para continuar',
            'admin_user_id.exists' => 'El gestor debe ser valido para continuar',
            'email.required' => 'El email es requerido para continuar',
            'email.email' => 'El email debe ser un email valido',
            'company.required' => 'El nombre de la empresa a es requerido para continuar',
            'cif.required' => 'El cif es requerido para continuar',
            'identifier.required' => 'La marca es requerida para continuar',
            'industry.required' => 'La industria es requerida para continuar',
            'activity.required' => 'La actividad es requerida para continuar',
            'address.required' => 'La dirección es requerida para continuar',
            'country.required' => 'El pais es requerido para continuar',
            'city.required' => 'La ciudad es requerida para continuar',
            'province.required' => 'La provincia es requerida para continuar',
            'zipcode.required' => 'El codigo postal es requerido para continuar',
            'phone.required' => 'El telefono es requerido para continuar',
        ]);

        $data = $request->all();
        $data['is_client'] = true;
        $clienteCreado = Client::create($data);
        // dd($clienteCreado);
        if($clienteCreado->pin == null){
            $clienteCreado->pin = rand(100000, 999999);
            $clienteCreado->save();
        }
        // Validamos si hay contacto asociado
        if (isset($data['newAssociatedContact'])) {
            foreach($data['newAssociatedContact'] as $newContacto){
                // dd(Auth::user()->id);
                $newContacto['admin_user_id'] = Auth::user()->id;
                $newContacto['civil_status_id'] = null;
                $newContacto['phone'] = $newContacto['telephone'];
                $newContacto['client_id'] = $clienteCreado->id;
                $newContacto['privacy_policy_accepted'] = false;
                $newContacto['cookies_accepted'] = false;
                $newContacto['newsletters_sending_accepted'] = false;
                // dd($newContacto);
                $contacto = Contact::create($newContacto);
                if (!$contacto) {
                    return session()->flash('toast', [
                        'icon' => 'error',
                        'mensaje' => "Error en el servidor, intentelo mas tarde."
                    ]);
                }
            }
        }

        // Teléfonos
        if($request->input('numbers')){
            foreach($request->input('numbers') as $key => $value) {
                if($value != ''){
                    $clientPhones = ClientPhone::create(['client_id'=> $clienteCreado->id,'number'=>$value]);
                    $clientPhonesSaved = $clientPhones->save();
                    if (!$clientPhonesSaved) {
                        return session()->flash('toast', [
                            'icon' => 'error',
                            'mensaje' => "Error en el servidor, intentelo mas tarde."
                        ]);
                    }
                }
            }
        }
        // Mails
        if($request->input('mails')){
            foreach($request->input('mails') as $key => $value) {
                if($value != ''){
                    $clientMails = ClientEmail::create(['client_id'=> $clienteCreado->id,'email'=>$value]);
                    $clientMailsSaved = $clientMails->save();
                    if (!$clientMailsSaved) {
                        return session()->flash('toast', [
                            'icon' => 'error',
                            'mensaje' => "Error en el servidor, intentelo mas tarde."
                        ]);
                    }
                }
            }
        }

        // Webs
        if($request->input('webs')){
            foreach($request->input('webs') as $key => $value) {
                if($value != ''){
                    // dd($value);
                    $clientWebs = ClientWeb::create(['client_id'=> $clienteCreado->id,'url'=>$value]);
                    $clientWebsSaved = $clientWebs->save();
                    if (!$clientWebsSaved) {
                        return session()->flash('toast', [
                            'icon' => 'error',
                            'mensaje' => "Error en el servidor, intentelo mas tarde."
                        ]);
                    }
                }
            }
        }
        // dd($data);

        session()->flash('toast', [
            'icon' => 'success',
            'mensaje' => 'El cliente se creo correctamente'
        ]);
        return redirect(route('presupuesto.create'))->with('clienteId', $clienteCreado->id);
    }
    public function storeFromPetition(Request $request)
    {
        //Validamos los campos
        $this->validate($request, [
            'name' => 'required|max:200',
            'admin_user_id' => 'required|exists:admin_user,id',
            'email' => 'required|email:filter',
            'phone' => 'required',
        ], [
            'name.required' => 'El nombre es requerido para continuar',
            'admin_user_id.required' => 'El gestor es requerido para continuar',
            'admin_user_id.exists' => 'El gestor debe ser valido para continuar',
            'email.required' => 'El email es requerido para continuar',
            'email.email' => 'El email debe ser un email valido',
            'phone.required' => 'El telefono es requerido para continuar',
        ]);


        $data = $request->all();
        $data['is_client'] = false;
        $clienteCreado = Client::create($data);

        session()->flash('toast', [
            'icon' => 'success',
            'mensaje' => 'El lead se creo correctamente'
        ]);
        return redirect(route('peticion.create'))->with('clienteId', $clienteCreado->id);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $cliente = Client::find($id);
        $coches = $cliente->coches;
        return view('clients.show', compact('cliente', 'coches'));

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $gestores = User::all();
        $clientes = Client::all();
        $cliente = Client::find($id);
        $contactos = Contact::where('client_id', $id)->get();
        $coches = $cliente->coches;
        $countries = Country::all();
        $allCoches = Coches::where(function($query) use ($id) {
            $query->where('cliente_id', '!=', $id)
                  ->orWhereNull('cliente_id');
        })->limit(10)->get();

        $presupuestos = Budget::where('client_id', $id) ->orderBy('created_at', 'desc') // Ordenar por la fecha de creación en orden descendente
        ->take(5) // Limitar a las últimas 5 reservas
        ->get();

        $cochesSustitucion  = CochesSustitucion::all()->filter(function ($coche) {
            return $coche->isDisponible();
        });
        

        $reservasCoche = ReservasCoche::where('cliente_id', $id)
        ->orderBy('created_at', 'desc') // Ordenar por la fecha de creación en orden descendente
        ->take(5) // Limitar a las últimas 5 reservas
        ->get();
        return view('clients.edit', compact('clientes', 'cliente', 'gestores', 'contactos', 'coches', 'countries', 'allCoches', 'reservasCoche', 'cochesSustitucion', 'presupuestos'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Validamos los campos
        $this->validate($request, [
            'name' => 'required|max:200',
            'admin_user_id' => 'required|exists:admin_user,id',
            'email' => 'required|email:filter',
            'company' => 'nullable|max:200',
            'cif' => 'nullable|max:200',
            'identifier' => 'nullable|max:200',
            'activity' => 'nullable|max:200',
            'address' => 'nullable|max:200',
            'country' => 'nullable|max:200',
            'city' => 'nullable|max:200',
            'province' => 'nullable|max:200',
            'zipcode' => 'nullable|max:200',
            'phone' => 'nullable',
            'pin' => 'nullable',
            'country' => 'nullable|max:200',
        ], [
            'name.required' => 'El nombre es requerido para continuar',
            'admin_user_id.required' => 'El gestor es requerido para continuar',
            'admin_user_id.exists' => 'El gestor debe ser valido para continuar',
            'email.required' => 'El email es requerido para continuar',
            'email.email' => 'El email debe ser un email valido',
            'company.required' => 'El nombre de la empresa es requerido para continuar',
            'cif.required' => 'El cif es requerido para continuar',
            'identifier.required' => 'La marca es requerida para continuar',
            'activity.required' => 'La actividad es requerida para continuar',
            'address.required' => 'La dirección es requerida para continuar',
            'country.required' => 'El pais es requerido para continuar',
            'city.required' => 'La ciudad es requerida para continuar',
            'province.required' => 'La provincia es requerida para continuar',
            'zipcode.required' => 'El codigo postal es requerido para continuar',
            'phone.required' => 'El telefono es requerido para continuar',
        ]);

        $cliente = Client::findOrFail($id);
        $data = $request->all();
        $data['is_client'] = true;
        $data['privacy_policy_accepted'] = $request->input('privacy_policy_accepted', false); // Valor por defecto
        
        $cliente->update($data);

        if($cliente->pin == null){
            $cliente->pin = rand(100000, 999999);
            $cliente->save();
        }

        // Validamos si hay contacto asociado
        if (isset($data['newAssociatedContact'])) {
            foreach ($data['newAssociatedContact'] as $newContacto) {
                $newContacto['admin_user_id'] = Auth::user()->id;
                $newContacto['civil_status_id'] = null;
                $newContacto['phone'] = $newContacto['telephone'];
                $newContacto['client_id'] = $cliente->id;
                $newContacto['privacy_policy_accepted'] = false;
                $newContacto['cookies_accepted'] = false;
                $newContacto['newsletters_sending_accepted'] = false;
                $contacto = Contact::updateOrCreate(
                    ['id' => $newContacto['id'] ?? null], // Usa 'id' para encontrar el contacto existente o crea uno nuevo
                    $newContacto
                );
                if (!$contacto) {
                    return session()->flash('toast', [
                        'icon' => 'error',
                        'mensaje' => "Error en el servidor, intentelo mas tarde."
                    ]);
                }
            }
        }

        // Teléfonos
        if ($request->input('numbers')) {
            foreach ($request->input('numbers') as $key => $value) {
                if ($value != '') {
                    $clientPhone = ClientPhone::updateOrCreate(
                        ['client_id' => $cliente->id, 'number' => $value]
                    );
                    if (!$clientPhone) {
                        return session()->flash('toast', [
                            'icon' => 'error',
                            'mensaje' => "Error en el servidor, intentelo mas tarde."
                        ]);
                    }
                }
            }
        }

        // Mails
        if ($request->input('mails')) {
            foreach ($request->input('mails') as $key => $value) {
                if ($value != '') {
                    $clientMail = ClientEmail::updateOrCreate(
                        ['client_id' => $cliente->id, 'email' => $value]
                    );
                    if (!$clientMail) {
                        return session()->flash('toast', [
                            'icon' => 'error',
                            'mensaje' => "Error en el servidor, intentelo mas tarde."
                        ]);
                    }
                }
            }
        }

        // Webs
        if ($request->input('webs')) {
            foreach ($request->input('webs') as $key => $value) {
                if ($value != '') {
                    $clientWeb = ClientWeb::updateOrCreate(
                        ['client_id' => $cliente->id, 'url' => $value]
                    );
                    if (!$clientWeb) {
                        return session()->flash('toast', [
                            'icon' => 'error',
                            'mensaje' => "Error en el servidor, intentelo mas tarde."
                        ]);
                    }
                }
            }
        }

        session()->flash('toast', [
            'icon' => 'success',
            'mensaje' => 'El cliente se actualizó correctamente'
        ]);

        return redirect()->route('clientes.show', $cliente->id);
    }

    public function storeCoche(Request $request)
{
    $validatedData = $request->validate([
        'matricula' => 'required|string|max:255',
        'vin' => 'nullable|string|max:255',
        'seguro' => 'nullable|string|max:255',
        'marca' => 'nullable|string|max:255',
        'modelo' => 'nullable|string|max:255',
        'anio' => 'nullable|integer',
        'km' => 'nullable|integer',
        'color' => 'nullable|string|max:255',
        'cliente_id' => 'required|exists:clients,id',
    ]);

    $validatedData['kilometraje'] = $validatedData['km'];

    // Buscar el coche por la matrícula
    $coche = Coches::where('matricula', $validatedData['matricula'])->first();
    if ($coche) {
        return redirect()->route('clientes.edit', $validatedData['cliente_id'])
            ->withErrors(['matricula' => 'El coche con esta matrícula ya existe.']);
    }

    Coches::create($validatedData);

    return redirect()->route('clientes.edit', $validatedData['cliente_id'])->with('success', 'Coche añadido correctamente.');
}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $cliente = Client::find($request->id);

        if (!$cliente) {
            return response()->json([
                'error' => true,
                'mensaje' => "Error en el servidor, intentelo mas tarde."
            ]);
        }

        $cliente->delete();
        return response()->json([
            'error' => false,
            'mensaje' => 'El usuario fue borrado correctamente'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function logo(string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function createFromBudget()
    {
        $gestores = User::all();
        $clientes = Client::all();
        return view('clients.createFromBudget', compact('gestores', 'clientes'));
    }
    public function createFromPetition()
    {
        $gestores = User::all();
        $clientes = Client::all();
        return view('clients.createFromPetition', compact('gestores', 'clientes'));
    }

    public function getGestorFromClient(Request $request){
        $client = Client::find($request->input('client_id'));
        $gestor = $client->gestor->id;
        return response($gestor);
    }
    public function getContactsFromClient(Request $request){
        $client = Client::find($request->input('client_id'));
        $contactos = $client->contacto;
        return response($contactos);
    }

    public function changeClient(Request $request)
    {
        $coche = Coches::find($request->coche_id);
        if ($coche) {
            $coche->cliente_id = $request->new_cliente_id;
            $coche->save();
            return response()->json(['success' => true, 'message' => 'Cliente cambiado exitosamente.']);
        }
        return response()->json(['success' => false, 'message' => 'Coche no encontrado.']);
    }

    public function removeCarFromClient(Request $request)
{
    $coche = Coches::find($request->coche_id);

    if ($coche) {
        $coche->cliente_id = null; // Desasociar el coche del cliente
        $coche->save();

        return response()->json(['success' => true, 'message' => 'Coche quitado del cliente exitosamente.']);
    }

    return response()->json(['success' => false, 'message' => 'Coche no encontrado.']);
}

    public function verificarClienteExistente(Request $request)
    {
        $clienteExistente = Client::where('phone', $request->phone)
            ->orWhere('cif', $request->cif) // Comprobación por DNI
            ->first();
        if($clienteExistente){
            return response()->json($clienteExistente );
        }else{
            return response()->json(false);
        }
        
    }

    public function searchCars(Request $request)
{
    $query = $request->input('query');
    $coches = Coches::where('matricula', 'LIKE', "%{$query}%")
    ->where(function($query) use ($request) {
        $query->where('cliente_id', '!=', $request->input('cliente_id'))
              ->orWhereNull('cliente_id');
    })
    ->get();
    return response()->json($coches);
}


public function storeCocheSustitucion(Request $request)
{
    $validatedData = $request->validate([
        'matricula' => 'required|string|max:255',
        'seguro' => 'nullable|string|max:255',
        'marca' => 'nullable|string|max:255',
        'vin' => 'nullable|string|max:255',
        'modelo' => 'nullable|string|max:255',
        'kilometraje' => 'nullable|integer',
        'color' => 'nullable|string|max:255',
        'anio' => 'nullable|integer',
    ]);

    CochesSustitucion::create($validatedData);

    return redirect()->back()->with('success', 'Coche de sustitución añadido con éxito.');
}

public function storeReservaCoche(Request $request)
{
    $validatedData = $request->validate([
        'coche_sustitucion_id' => 'required|exists:coches_sustitucion,id',
        'fecha_inicio' => 'required|date',
        'fecha_fin' => 'nullable|date|after_or_equal:fecha_inicio',
        'estado' => 'required|string',
        'comentario' => 'nullable|string',
        'km_actual' => 'nullable|integer',
        'km_entregado' => 'nullable|integer',
    ]);

    $validatedData['cliente_id'] = $request->input('cliente_id');
    ReservasCoche::create($validatedData);

    return redirect()->back()->with('success', 'Reserva de coche de sustitución añadida con éxito.');
}


public function destroyReservaCoche($id)
{
    $reserva = ReservasCoche::findOrFail($id);
    $reserva->delete();

    return redirect()->back()->with('success', 'Reserva de coche de sustitución eliminada con éxito.');
}

public function updateReservaCoche(Request $request, $id)
{
    $reserva = ReservasCoche::findOrFail($id);

    $validatedData = $request->validate([
        'estado' => 'sometimes|required|string|in:pendiente,entregado,devuelto',
        'fecha_fin' => 'sometimes|required|date|after_or_equal:fecha_inicio',
        'km_actual' => 'sometimes|required|integer',
        'km_entregado' => 'sometimes|required|integer',
    ]);

    $reserva->update($validatedData);

    return response()->json(['success' => true, 'message' => 'Reserva actualizada con éxito.']);
}

}
