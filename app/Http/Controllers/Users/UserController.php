<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Http\Requests\Users\RequestStore;
use Illuminate\Foundation\Auth\RegistersUsers;

use Illuminate\Http\Request;
use App\Models\Users\User;
use App\Models\Users\UserAccessLevel;
use App\Models\Users\UserDepartament;
use App\Models\Users\UserPosition;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use App\Models\Jornada\Jornada;


class UserController extends Controller
{
    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    // protected $redirectTo = RouteServiceProvider::HOME;


    // /**
    //  * Create a new controller instance.
    //  *
    //  * @return void
    //  */
    // public function __construct()
    // {
    //     $this->middleware('guest');
    // }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        // session()->flash('toast','Esto es una prueba');
        $usuarios = User::where('inactive', 0)->get();
        return view('users.index', compact('usuarios'));
    }

    public function startJornada(Request $request)
    {
        $pin = $request->input('pin');
        $user = User::where('pin', $pin)->first();
        $today = Carbon::today();

        if (!$user) {
            return response()->json(['success' => false, 'message' => 'Usuario no encontrado.']);
        }

        // Verificar si ya existe una jornada activa para hoy
        $jornada = Jornada::where('admin_user_id', $user->id)
                          ->whereDate('start_time', $today)
                          ->where('is_active', true)
                          ->first();

    

        if ($jornada) {
            return response()->json(['success' => false, 'message' => 'Ya tienes una jornada activa.']);
        }

        //busca alguna jornada de este usuario de dias anteriores que este activa y la finaliza
        $jornadasAnteriores = Jornada::where('admin_user_id', $user->id)
                          ->whereDate('start_time', '<', $today)
                          ->where('is_active', true)
                          ->get();

        foreach ($jornadasAnteriores as $jornada) {

            //endtime debe ser la fecha de inicio de la jornada a las 23:59
            $endTime = Carbon::parse($jornada->start_time)->addDay()->subSecond();

            $jornada->update(['is_active' => false , 'end_time' => $endTime]);

        }

        

        // Crear una nueva jornada
        Jornada::create([
            'admin_user_id' => $user->id,
            'start_time' => now(),
            'is_active' => true
        ]);

        return response()->json(['success' => true, 'message' => 'Jornada iniciada con éxito.']);
    }

    public function endJornada(Request $request)
    {
        $pin = $request->input('pin');
        $user = User::where('pin', $pin)->first();
        $today = Carbon::today();

        if (!$user) {
            return response()->json(['success' => false, 'message' => 'Usuario no encontrado.']);
        }

        // Buscar la jornada activa de hoy
        $jornada = Jornada::where('admin_user_id', $user->id)
                          ->whereDate('start_time', $today)
                          ->where('is_active', true)
                          ->first();

        if (!$jornada) {
            return response()->json(['success' => false, 'message' => 'No tienes una jornada activa para finalizar.']);
        }

        // Finalizar la jornada
        $jornada->update([
            'end_time' => now(),
            'is_active' => false
        ]);

        return response()->json(['success' => true, 'message' => 'Jornada finalizada con éxito.']);
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:admin_user'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $role = UserAccessLevel::all();
        $departamentos = UserDepartament::all();
        $posiciones = UserPosition::all();

        return view('users.create', compact('role','departamentos', 'posiciones'));

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $this->validate($request, [
            'name' => 'required|max:200',
            'surname' => 'required|max:200',
            'username' => 'required|unique:admin_user',
            'email' => 'required|email:filter',
            'password' => 'required|min:8',
            'access_level_id' => 'required|exists:admin_user_access_level,id',
            'admin_user_department_id' => 'required|exists:admin_user_department,id',
            'admin_user_position_id' => 'required|exists:admin_user_position,id',
            'pin' => 'nullable|min:4|max:4|unique:admin_user,pin',
        ], [
            'name.required' => 'El nombre es requerido para continuar',
            'surname.required' => 'Los apellidos son requeridos para continuar',
            'username.required' => 'El nombre de usuario es requerido para continuar',
            'username.unique' => 'El nombre de usuario ya existe',
            'email.required' => 'El email es requerido para continuar',
            'email.email' => 'El email debe ser un email valido',
            'password.required' => 'El password es requerido para continuar',
            'password.min' => 'El password debe contener al menos 8 caracteres para continuar',
            'access_level_id.exists' => 'El rol debe ser valido y es requerido para continuar',
            'admin_user_department_id.exists' => 'El departamento debe ser valido y es requerido para continuar',
            'admin_user_position_id.exists' => 'La posicion debe ser valido y es requerido para continuar',
            'pin.min' => 'El pin debe contener al menos 4 caracteres para continuar',
            'pin.max' => 'El pin debe contener al menos 4 caracteres para continuar',
            'pin.unique' => 'El pin ya existe',
        ]);

          $data = $request->all();

          $data['role'] = 'Admin';
          $data['inactive'] = 0;
          $data['password'] = Hash::make($data['password']);

        //   dd($data);
          $usuarioCreado = User::create($data);

        session()->flash('toast', [
            'icon' => 'success',
            'mensaje' => 'El usuario se creo correctamente'
        ]);

        return redirect()->route('users.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $usuario = User::find($id);
        if(is_null($usuario)){

        }

        return view('users.show', compact('usuario'));
    }

    public function validatePin($pin)
    {
        $user = User::where('pin', $pin)->first();

        if ($user) {
            $jornadas = Jornada::where('admin_user_id', $user->id)->where('start_time', '>=', Carbon::now()->subDay())->get();
            $totalWorkedSeconds = 0;

            $jornadasData = $jornadas->map(function ($jornada) use (&$totalWorkedSeconds) {
                $startTime = Carbon::parse($jornada->start_time);
                $endTime = $jornada->end_time ? Carbon::parse($jornada->end_time) : now();
                $workedSeconds = $endTime->diffInSeconds($startTime);
                $totalWorkedSeconds += $workedSeconds;

                return [
                    'start_time' => $jornada->start_time,
                    'end_time' => $jornada->end_time,
                    'is_active' => $jornada->is_active,
                    'worked_hours' => gmdate('H:i:s', $workedSeconds)
                ];
            });

            $totalWorkedHours = gmdate('H:i:s', $totalWorkedSeconds);

            return response()->json([
                'valid' => true,
                'jornadas' => $jornadasData,
                'userName' => $user->name,
                'totalWorkedHours' => $totalWorkedHours
            ]);
        } else {
            return response()->json(['valid' => false]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $usuario = User::find($id);

        if (!$usuario) {
            session()->flash('toast', [
                'icon' => 'error',
                'mensaje' => 'El usuario no existe'
            ]);
            return redirect()->route('users.index');
        }
        $role = UserAccessLevel::all();
        $departamentos = UserDepartament::all();
        $posiciones = UserPosition::all();
        return view('users.edit', compact('usuario', 'role', 'departamentos', 'posiciones'));

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $this->validate($request, [
            'name' => 'required|max:200',
            'surname' => 'required|max:200',
            'username' => 'required|unique:admin_user,username,' . $id, // Permitir el mismo username si pertenece al usuario actual
            'email' => 'required|email:filter',
            'password' => 'nullable|min:8',
            'access_level_id' => 'required|exists:admin_user_access_level,id',
            'admin_user_department_id' => 'required|exists:admin_user_department,id',
            'admin_user_position_id' => 'required|exists:admin_user_position,id',
            'pin' => 'nullable|min:4|max:4|unique:admin_user,pin,' . $id,
        ], [
            'name.required' => 'El nombre es requerido para continuar',
            'surname.required' => 'Los apellidos son requeridos para continuar',
            'username.required' => 'El nombre de usuario es requerido para continuar',
            'username.unique' => 'El nombre de usuario ya existe',
            'email.required' => 'El email es requerido para continuar',
            'email.email' => 'El email debe ser un email valido',
            'password.required' => 'El password es requerido para continuar',
            'password.min' => 'El password debe contener al menos 8 caracteres para continuar',
            'access_level_id.exists' => 'El rol debe ser valido y es requerido para continuar',
            'admin_user_department_id.exists' => 'El departamento debe ser valido y es requerido para continuar',
            'admin_user_position_id.exists' => 'La posicion debe ser valido y es requerido para continuar',
            'pin.min' => 'El pin debe contener al menos 4 caracteres para continuar',
            'pin.max' => 'El pin debe contener maximo 4 caracteres para continuar',
            'pin.unique' => 'El pin ya existe',
        ]);

        $user = User::findOrFail($id); // Buscar el usuario existente

        $data = $request->all();

        // Solo actualizar la contraseña si se proporciona una nueva
        if ($request->filled('password')) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']);
        }

        $data['role'] = 'Admin';
        $data['inactive'] = 0;

        $user->update($data);

        session()->flash('toast', [
            'icon' => 'success',
            'mensaje' => 'El usuario se actualizó correctamente'
        ]);

        return redirect()->route('users.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $user = User::find($request->id);

        if (!$user) {
            return response()->json([
                'error' => true,
                'mensaje' => "Error en el servidor, intentelo mas tarde."
            ]);
        }

        $user->inactive = 1;
        $user->save();

        return response()->json([
            'error' => false,
            'mensaje' => 'El usuario fue borrado correctamente'
        ]);
    }

    public function avatar(Request $request, $id)
    {
        $file = $request->file('filepond');
        $new_name = uniqid(rand(), true).'.'.strtolower($file->getClientOriginalExtension());
        $result = Storage::disk('public')->put('avatars/'.$new_name, File::get($file));
        $usuario = User::find($id);
        if (Storage::disk('public')->exists('avatars/'.$usuario->image)) {
            Storage::disk('public')->delete('avatars/'.$usuario->image);
        }
            $usuario['image'] = $new_name;
            // dd($usuario);
            $usuario->save();

            session()->flash('toast', [
                'icon' => 'success',
                'mensaje' => 'La imagen del usuario se actualizo correctamente'
            ]);

        return $new_name;

    }

    public function base64ToImage($base64_string, $output_file) {
        $file = fopen($output_file, "wb");

        $data = explode(',', $base64_string);

        fwrite($file, base64_decode($data[1]));
        fclose($file);

        return $output_file;
    }

    public function saveThemePreference(Request $request)
    {
        $user = auth()->user();
        $user->is_dark = $request->input('is_dark');
        // dd($request->input('is_dark'));
        $user->save();

        return response()->json(['message' => 'Preferencia de tema guardada con éxito.']);
    }

}
