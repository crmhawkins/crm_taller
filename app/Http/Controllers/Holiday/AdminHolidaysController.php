<?php

namespace App\Http\Controllers\Holiday;

use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Holidays\Holidays;
use App\Models\Holidays\HolidaysAdditions;
use App\Models\Holidays\HolidaysPetitions;
use App\Models\Alerts\Alert;
use Illuminate\Support\Facades\Mail;
use App\Mail\MailHoliday;
use App\Models\Users\User;
use Carbon\Carbon;


class AdminHolidaysController extends Controller
{
    /**
     * Mostrar la lista de usuarios y el número de vacaciones
     *
     */
    public function index()
    {

        return view('holidays.indexAdmin');
    }

     /**
     * Mostrar el formulario de edición
     *
     * @param  Holidays  $holiday
     *
     */
    public function edit(Holidays $holiday, Request $request)
    {
        $holidays = Holidays::where('admin_user_id', 'admin_user_id')->get();
        return view('admin.admin_holidays.edit', compact('holidays', 'request'));
    }

    /**
     * Actualizar registro
     *
     * @param  Request  $request
     * @param  Holidays  $holiday
     *
     */
    public function update(Request $request, Holidays $holiday)
    {
        // Validación
        $request->validate([
            'quantity' => 'required|between:0,99.99',
        ]);

        // Datos del formulario
        $data = $request->all();
        $oldQuantity = $holiday->quantity;
        $daysToAdd = $data['quantity'];
        $holidaysDays =  $oldQuantity  +   $daysToAdd;

        $data['quantity'] = $holidaysDays;

        // Actualizar días de vacaciones
        $holiday->fill($data);
        $holidaySaved = $holiday->save();

        if($holidaySaved){
            DB::table('holidays_additions')->insert([
                [
                    'admin_user_id' => $holiday->admin_user_id,
                    'quantity_before' => $oldQuantity,
                    'quantity_to_add' => $daysToAdd,
                    'quantity_now' => $holidaysDays,
                    'manual' => 1,
                    'holiday_petition' => 0,
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                ],
            ]);
        }

        // Respuesta
        return redirect()->route('admin_holiday.edit',$holiday->id)->with('toast', [
            'icon' => 'success',
            'mensaje' => 'Nuevo registro actualizado correctamente'
          ]
      );

    }

    /**
     * Mostrar el historial de actualizaciones de vacaciones (días añadidos, quitados)
     *
     */
    public function addedRecord()
    {
        //$holidays = DB::table('holidays')->get();
        $holidaysAdditions = HolidaysAdditions::orderBy('id', 'desc')->get();


        return view('admin.admin_holidays.record', compact('holidaysAdditions'));
    }

    /**
     * Mostrar historial de vacaciones de todo el mundo
     *
     */
    public function allHistory()
    {
        $holidays = HolidaysPetitions::orderBy('id', 'desc')->withTrashed()->get();
        $today = date("Y-m-d");

        return view('admin.admin_holidays.allhistory', compact('holidays','today'));
    }

    /**
     * Gestión de vacaciones
     *
     */
    public function usersPetitions(){

        $holidaysPetitions = HolidaysPetitions::orderBy('created_at', 'asc')->get();
        $numberOfholidaysPetitions = HolidaysPetitions::where('holidays_status_id', 3)->count();

        $holydayEvents = [];
        $data = HolidaysPetitions::orderBy('created_at', 'asc')->get();

        if ($data->count()) {
            foreach ($data as $value) {
                $color = '#FFFFFF'; // Color por defecto

                // Asignar color según el estado
                if ($value->holidays_status_id == 1) {
                    $color = '#C3EBC4'; // Color para estado 1
                } elseif ($value->holidays_status_id == 2) {
                    $color = '#FBC4C4'; // Color para estado 2
                } elseif ($value->holidays_status_id == 3) {
                    $color = '#FFDD9E'; // Color para estado 3
                }

                // Verificar si el usuario está asociado con la petición
                if ($value->adminUser) {
                    $holydayEvents[] = [
                        'title' => $value->adminUser->name, // Título del evento
                        'start' => (new \DateTime($value->from))->format('Y-m-d'), // Fecha de inicio
                        'end' => (new \DateTime($value->to . ' +1 day'))->format('Y-m-d'), // Fecha de fin
                        'endTrue' => (new \DateTime($value->to))->format('Y-m-d'), // Fecha de fin
                        'color' => $color, // Color del evento
                        'id' => $value->id,
                    ];
                }
            }
        }

        return view('holidays.gestion',compact('numberOfholidaysPetitions','holydayEvents'));
    }

     /**
     * Gestión de una petición
     *
     * @param  HolidaysPetitions  $holidayPetition
     *
     */
    public function managePetition(string $id)
    {
        $holidayPetition = HolidaysPetitions::find($id);
        $userId = Auth::id();
        $usuario = User::find($userId);
        return view('holidays.managePetitions', compact('holidayPetition', 'usuario'));
    }

    /**
     * Aceptar petición
     *
     * @param  Request  $request
     * @param  HolidaysPetitions  $holidayPetition
     *
     */
    public function acceptHolidays(Request $request)
    {
        $holidayPetition = HolidaysPetitions::find($request->id);
        $fechaNow = Carbon::now();

        $data = $request->all();
        $data['holidays_status_id'] = 1;

        try {
            $holidayPetition->fill($data);
            $holidaySaved = $holidayPetition->save();

            if($holidaySaved){
                //Alerta resuelta
                $alertHoliday = Alert::where('stage_id', 16)->where('reference_id', $holidayPetition->id)->get()->first();
                $alertHoliday->status_id = 2;
                $alertHoliday->save();

                // Crear alerta para avisar al usuario
                $data = [
                    'admin_user_id' => $holidayPetition->admin_user_id,
                    'stage_id' => 17,
                    'activation_datetime' => $fechaNow->format('Y-m-d H:i:s'),
                    'status_id' => 1,
                    'reference_id' => $holidayPetition->id
                ];

                $alert = Alert::create($data);
                $alertSaved = $alert->save();


                // $mailBudget = new \stdClass();
                // $mailBudget->usuario = Auth::user()->name." ".Auth::user()->surname;
                // $mailBudget->usuarioMail = Auth::user()->email;
                // $mailBudget->from = $holidayPetition->from;
                // $mailBudget->to = $holidayPetition->to;


                // $allHolidays = Holidays::all();
                // $mailBudget->usuarios = $allHolidays;

                // Mail::to("ivan@lchawkins.com")
                // ->cc(Auth::user()->email)
                // ->send(new MailHoliday($mailBudget));

                $empleado = User::where("id", $holidayPetition->admin_user_id)->first();

                $this->sendEmail($empleado);

                // Respuesta
                return response()->json(['status' => 'success', 'mensaje' => 'Petición de vacaciones aceptada correctamente']);

            }
        } catch (\Exception $e) {
             // Respuesta
             return response()->json(['status' => 'error', 'mensaje' => 'Error al aceptar la petición']);

        }
    }


    /**
     * Denegar petición
     *
     * @param  Request  $request
     * @param  HolidaysPetitions  $holidayPetition
     *
     */
    public function denyHolidays(Request $request){

        $holidayPetition = HolidaysPetitions::find($request->id);
        if($holidayPetition->holidays_status_id !=2){
            try {
                //Denegar petición
                $holidayPetitionToDeny = holidaysPetitions::where('id', $holidayPetition->id )->update(array('holidays_status_id' => 2 ));

                if($holidayPetitionToDeny){

                    $RecoveryDays = Holidays::where('admin_user_id', $holidayPetition->admin_user_id)->get()->first();

                    $RecoveryDays->quantity += $holidayPetition->total_days;
                    $addrecord = $RecoveryDays->save();
                    if($addrecord){
                        HolidaysAdditions::create([
                            'admin_user_id' => $holidayPetition->admin_user_id,
                            'quantity_before' => $RecoveryDays->quantity - $holidayPetition->total_days,
                            'quantity_to_add' => $holidayPetition->total_days,
                            'quantity_now' => $RecoveryDays->quantity,
                            'manual' => 0,
                            'holiday_petition' => 0,
                            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                        ]);
                    }

                    //Alerta resuelta
                    $alertHoliday = Alert::where('stage_id', 16)->where('reference_id', $holidayPetition->id)->get()->first();
                    $alertHoliday->status_id = 2;
                    $alertHoliday->save();
                    $fechaNow = Carbon::now();
                    //Crear alerta para avisar al usuario
                    $data = [
                        'admin_user_id' => $holidayPetition->admin_user_id,
                        'stage_id' => 18,
                        'activation_datetime' => $fechaNow->format('Y-m-d H:i:s'),
                        'status_id' => 1,
                        'reference_id' => $holidayPetition->id
                    ];

                    $alert = Alert::create($data);
                    $alertSaved = $alert->save();

                    // Respuesta
                    return response()->json(['status' => 'success', 'mensaje' => 'Petición de vacaciones denegada correctamente']);
                }
            } catch (\Exception $e) {
                // Respuesta
                return response()->json(['status' => 'error', 'mensaje' => 'Error al denegar la petición']);

            }
        }else{
            return response()->json(['status' => 'success', 'mensaje' => 'Petición de vacaciones denegada correctamente']);
        }
    }


    // Envía un mensaje al usuario cuando se acepta la petición
    public function sendEmail($empleado){

        // Si el estado es 1, es solicitud de vacaciones, el 2 es aceptada, el 3 es rechazada
        $estado = 2;
        $email = new MailHoliday($estado, $empleado);

        Mail::to($empleado->email)->send($email);

        return 200;

    }
    /**
     *  Mostrar el formulario de creación
     *
     */
    public function create()
    {
        $adminUsers = User::orderBy('name', 'asc')->where('inactive',0)->get();
        return view('admin.admin_holidays.create',  compact('adminUsers'));
    }

     /**
     * Guardar nuevo registro
     *
     * @param  Request  $request
     *
     */
    public function store(Request $request)
    {
        // Validación
        $request->validate([
            'quantity' => 'required|between:0,99.99',
        ]);

        // Formulario datos
        $data = $request->all();

        // Guardar
        $holiday = Holidays::create($data);
        $holidaySaved = $holiday->save();

        // Respuesta
        return redirect()->route('holiday.edit',$holiday->id)->with('toast', [
            'icon' => 'succcess',
            'mensaje' => 'Nuevo registro guardado correctamente'
          ]
      );

    }



    /**
     * Borrar registro
     *
     * @param  Holidays  $password
     *
     */
    public function destroy(Holidays $holiday)
    {
        try {
            //Borrar registro
            $deleted = $holiday->delete();
            // Respuesta
            return redirect()->back()->with('toast', [
                'icon' => 'success',
                'mensaje' => 'El registro se borró correctamente'
              ]
          );
        } catch (\Exception $e) {
             // Respuesta
             return redirect()->back()->with('toast', [
                'icon' => 'error',
                'mensaje' => 'El registro no pudo ser eliminada.Pruebe más tarde.'
              ]
          );
        }
    }
    public function getDate(holidaysPetitions $holidaysPetitions){
        return response()->json([ 'fecha_inicio' =>$holidaysPetitions->from]);
    }

    public function createHoliday()
    {
        $user = User::all();

        return view('holidays.create_admin', compact( 'user'));
    }


    public function storeHoliday(Request $request)
    {


        // Validación
        $request->validate([
            'from_date' => 'required',
            'to_date' => 'required|after_or_equal:from_date',
        ]);


        // Formulario datos
        $data = $request->all();
        $data['holidays_status_id'] = 1; //Pending

        // Dates
        if(isset($data['from_date'])){
            if ($data['from_date'] != null){
                $data['from_date'] = date('Y-m-d', strtotime(str_replace('/', '-',  $data['from_date'])));
            }
        }
        if(isset($data['to_date'])){
            if ($data['to_date'] != null){
                $data['to_date'] = date('Y-m-d', strtotime(str_replace('/', '-',  $data['to_date'])));
            }
        }

        // Booleans
        if (!isset($data['half_day'])) {
            $data['half_day'] = 0;
        }else{
            //Si se marcó la casilla será medio día
            $data['half_day'] = 1;
        }

        // Fecha DESDE enviada desde formulario
        $dataFromToTime = strtotime($data['from_date']);
        $dataFromDateTime = new \DateTime();
        $dataFromDateTime->setTimestamp($dataFromToTime);
        // Fecha HASTA enviada desde formulariof
        $dataToToTime = strtotime($data['to_date']);
        $dataToDateTime = new \DateTime();
        $dataToDateTime->setTimestamp($dataToToTime);

        if($data['half_day'] == 1){
            if($dataFromDateTime != $dataToDateTime){
                return redirect()->back()->with('toast', [
                      'icon' => 'error',
                      'mensaje' => 'No se pueden pedir medios días en intervalos'
                    ]
                );
            }
        }

        // Días que tiene de vacaciones
        $userHolidaysQuantity = Holidays::where('admin_user_id', $data['admin_user_id'] )->get()->first();

        // Días que tiene pedidos
        $holidaysPetitions = HolidaysPetitions::where('admin_user_id', $data['admin_user_id'] )->orderBy('created_at', 'asc')->get();

        // Calcular cuantos días está pidiendo
        $petitionQuantityDaysInterval =  $dataFromDateTime->diff($dataToDateTime);
        $petitionQuantityDays = $petitionQuantityDaysInterval->days;
        $petitionQuantityDays += 1;

        // Si la fecha es la misma se ha pedido 1 día.
        $petitionSingleDay = false;
        if ($dataFromDateTime == $dataToDateTime ){
            $petitionSingleDay = true;
        }
        if( $petitionSingleDay == true){
            if( $data['half_day'] == 1){
                $petitionQuantityDays -= 0.5;
            }
        }

        ////////////////////////////////////////
        //   Condiciones que deben cumplirse: //
        ////////////////////////////////////////

        // Si alguno de los días es sábado o domingo no puede pedirse vacaciones
        $signleDayisWeekend = false;
        if($dataFromDateTime->format('N') >= 6){
            $signleDayisWeekend = true;
        }

        // Si es fin de semana y un día solo
        if( $petitionSingleDay && $signleDayisWeekend){
            return redirect()->back()->with('toast', [
                'icon' => 'error',
                'mensaje' => 'La fecha no puede ser fin de semana'
              ]
          );
        }

        // Si es fin de semana y un intervalo
        $start = $dataFromDateTime;
        $end = $dataToDateTime;
        $end->modify('+1 day');
        $period = new \DatePeriod($start, new \DateInterval('P1D'), $end);
        foreach($period as $dt) {
            $curr = $dt->format('D');
            // Si es Sábado o Domingo
            if ($curr == 'Sat' || $curr == 'Sun' ) {
                return redirect()->back()->with('toast', [
                    'icon' => 'error',
                    'mensaje' => 'Las fechas no pueden ser fin de semana'
                  ]
              );
            }
        }
        //****** BUG *****
        // No deja por ejemplo si el usuario tiene el dia 25 y 27 el 26 estando libre


        // Que no tenga vacaciones ya pedidas ese día o periodo
        foreach($holidaysPetitions as $holidaysPetition ){
            // Desde
            $petitionFromToTime = strtotime($holidaysPetition->from);
            $petitionFromDateTime = new \DateTime();
            $petitionFromDateTime->setTimestamp($petitionFromToTime);
            // Hasta
            $petitionToToTime = strtotime($holidaysPetition->to);
            $petitionToDateTime = new \DateTime();
            $petitionToDateTime->setTimestamp($petitionToToTime);
            $dataToDateTime->modify('-1 day');
            // Comprobar si están en medio las fechas de ya disponibles
            $dateFromDateTimeIsBetween = $dataFromDateTime >= $petitionFromDateTime && $dataFromDateTime <= $petitionToDateTime ;
            $dateToDateTimeIsBetween = $dataToDateTime >= $petitionFromDateTime && $dataToDateTime <= $petitionToDateTime;

        }

        // Que la/s fecha/s introducidas sean mayor o igual que la actual
        $today =  strtotime(date("Y-m-d"));
        $todayTime = new \DateTime();
        $todayTime->setTimestamp($today);
        $dataToToTime = strtotime($data['to_date']);
        $dataToDateTime = new \DateTime();
        $dataToDateTime->setTimestamp($dataToToTime);

        if($dataFromDateTime < $todayTime || $dataToDateTime < $todayTime ){
            return redirect()->back()->with('toast', [
                'icon' => 'error',
                'mensaje' => 'Las fechas deben ser posterior a la actual'
              ]
          );
        }

        // Si dispone de los días necesarios
        if( $petitionQuantityDays > $userHolidaysQuantity->quantity   ){
            return redirect()->back()->with('toast', [
                'icon' => 'error',
                'mensaje' => 'No dispone de días de vacaciones suficientes'
              ]
          );
        }

        //formatear datos
        if(isset($data['from_date'])){
            if ($data['from_date'] != null){
                $data['from_date'] = date('Y-m-d', strtotime(str_replace('/', '-',  $data['from_date'])));
            }
        }
        if(isset($data['to_date'])){
            if ($data['to_date'] != null){
                $data['to_date'] = date('Y-m-d', strtotime(str_replace('/', '-',  $data['to_date'])));
            }
        }
        $from = $data['from_date'];
        $to = $data['to_date'];
        $data['from'] =$data['from_date'];
        $data['to'] =$data['to_date'];
        $data['total_days'] = $petitionQuantityDays;
        $petitionQuantityDaysNegative = -1 * abs($petitionQuantityDays);

        // Guardar
        $holidayPetition = HolidaysPetitions::create($data);
        $holidayPetitionSaved = $holidayPetition->save();

        // Resto las vacaciones
        if($holidayPetitionSaved){
            $updatedHolidaysQuantity =  $userHolidaysQuantity->quantity - $petitionQuantityDays;
            // Actualizo los días de vacaciones del usuario en la base de datos
            if($updatedHolidaysQuantity >= 0){
                $updateHolidaysDone = Holidays::where('admin_user_id', Auth::user()->id )->update(array('quantity' => $updatedHolidaysQuantity ));
            }
            // Añado un registro en holidays_additions guardando esta operación
            if($updateHolidaysDone){
                DB::table('holidays_additions')->insert([
                    [
                        'admin_user_id' => $data['admin_user_id'],
                        'quantity_before' => $userHolidaysQuantity->quantity,
                        'quantity_to_add' => $petitionQuantityDaysNegative,
                        'quantity_now' => $updatedHolidaysQuantity,
                        'manual' => 0,
                        'holiday_petition' => 1,
                        'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    ],
                ]);
            }
        }
        // Respuesta
        return redirect()->route('holiday.admin.petitions',)->with('toast', [
            'icon' => 'success',
            'mensaje' => 'La petición de vacaciones se realizó correctamente'
          ]
      );

    }

}
