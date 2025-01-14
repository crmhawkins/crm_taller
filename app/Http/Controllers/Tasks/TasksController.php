<?php

namespace App\Http\Controllers\Tasks;

use App\Http\Controllers\Controller;
use App\Models\Jornada\Jornada;
use App\Models\Prioritys\Priority;
use App\Models\Tasks\LogTasks;
use App\Models\Tasks\Task;
use App\Models\Tasks\TaskStatus;
use App\Models\Users\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TasksController extends Controller
{
    public function index()
    {
        $tareas = Task::all();
        return view('tasks.index', compact('tareas'));
    }

    public function all()
{
    $tareas = Task::with(['usuario', 'estado'])
    ->whereNotIn('task_status_id', [3, 4])
    ->get();
    if (request()->ajax()) {
        return response()->json($tareas);
    }

    return view('tasks.all', compact('tareas'));
}

public function search(Request $request)
{
    $search = $request->get('q');
    $users = User::where('name', 'LIKE', "%$search%")->get();

    return response()->json($users);
}

public function assignTaskToUser($taskId, $userId)
{
    $task = Task::find($taskId);
    $user = User::find($userId);

    if (!$task || !$user) {
        return response()->json(['success' => false, 'message' => 'Tarea o usuario no encontrado.']);
    }

    $task->admin_user_id = $userId;
    $task->save();

    return response()->json(['success' => true, 'message' => 'Usuario asignado correctamente a la tarea.']);
}

public function assignTask($id)
{
    $task = Task::find($id);
    if (!$task) {
        return response()->json(['success' => false, 'message' => 'Tarea no encontrada.']);
    }

    // Verificar si la tarea ya tiene un responsable
    if ($task->admin_user_id) {
        return response()->json(['success' => false, 'message' => 'La tarea ya tiene un responsable.']);
    }

    // Asignar el usuario actual como responsable de la tarea
    $task->admin_user_id = auth()->id();
    $task->save();

    return response()->json(['success' => true, 'message' => 'Tarea asignada correctamente.']);
}

public function getAllTasksJson()
   {
    $tareas = Task::with(['usuario', 'estado'])
    ->whereNotIn('task_status_id', [3, 4])
    ->get();
       return response()->json($tareas);
   }

public function unassignTask($id)
{
    $task = Task::find($id);
    if (!$task) {
        return response()->json(['success' => false, 'message' => 'Tarea no encontrada.']);
    }

    // Verificar si el usuario actual es el responsable de la tarea
    if ($task->admin_user_id != auth()->id()) {
        return response()->json(['success' => false, 'message' => 'No tienes permiso para desasignar esta tarea.']);
    }

    // Desasignar el usuario actual de la tarea
    $task->admin_user_id = null;
    $task->save();

    return response()->json(['success' => true, 'message' => 'Tarea desasignada correctamente.']);
}


public function startTask($id)
{
    $task = Task::find($id);
    if (!$task) {
        return response()->json(['success' => false, 'message' => 'Tarea no encontrada.']);
    }

    // Lógica para iniciar la tarea
    $task->task_status_id = 1; // Suponiendo que 1 es el ID para "En progreso"
    $task->save();

    return response()->json(['success' => true, 'message' => 'Tarea iniciada correctamente.']);
}

public function pauseTask($id)
{
    $task = Task::find($id);
    if (!$task) {
        return response()->json(['success' => false, 'message' => 'Tarea no encontrada.']);
    }

    // Lógica para pausar la tarea
    $task->task_status_id = 2; // Suponiendo que 2 es el ID para "Pausada"
    $task->save();

    return response()->json(['success' => true, 'message' => 'Tarea pausada correctamente.']);
}

public function finishTask($id)
{
    $task = Task::find($id);
    if (!$task) {
        return response()->json(['success' => false, 'message' => 'Tarea no encontrada.']);
    }

    // Lógica para finalizar la tarea
    $task->task_status_id = 3; // Suponiendo que 3 es el ID para "Finalizada"
    $task->save();

    return response()->json(['success' => true, 'message' => 'Tarea finalizada correctamente.']);
}



    public function cola()
    {
        $usuarios = User::where('access_level_id',5)->where('inactive', 0)->get();
        //$usuarios = User::all();
        return view('tasks.cola', compact('usuarios'));
    }
    public function revision()
    {
        $tareas = Task::all();
        return view('tasks.revision', compact('tareas'));
    }
    public function asignar()
    {
        $tareas = Task::all();
        return view('tasks.asignar', compact('tareas'));
    }

    public function edit(string $id)
    {
        $task = Task::find($id);

        if(!isset($task)){
            return redirect()->route('tareas.index')->with('toast',[
                'icon' => 'success',
                'mensaje' => 'Tarea no encontrada'
            ]);
        }

        $employees = User::where('inactive', 0)->get();
        $prioritys = Priority::all();
        $status = TaskStatus::all();
        $data = [];
        if ($task->duplicated == 0) {
            $trabajador = User::find($task->admin_user_id);
            if ($trabajador) {
                $data = [
                    '0' => [
                        'num' => 1,
                        'id' => $trabajador->id,
                        'trabajador' => $trabajador->name,
                        'horas_estimadas' => $task->estimated_time,
                        'horas_reales' => $task->real_time,
                        'status' => $task->task_status_id,
                        'task_id' => $task->id,
                    ],
                ];
            }
        } else {
            $count = 1;
            $tareasDuplicadas = Task::where(
                'split_master_task_id',
                $task->id
            )->get();
            $trabajador = User::find($task->admin_user_id);

            if ($trabajador) {
                $data = [
                    '0' => [
                        'num' => 1,
                        'id' => $trabajador->id,
                        'trabajador' => $trabajador->name,
                        'horas_estimadas' => $task->estimated_time,
                        'horas_reales' => $task->real_time,
                        'status' => $task->task_status_id,
                        'task_id' => $task->id,
                    ],
                ];
            } else {
                $count = 0;
            }

            foreach ($tareasDuplicadas as $tarea) {
                if ($tarea->admin_user_id) {

                    $trabajador = User::find($tarea->admin_user_id);
                    if ($trabajador == null ) {
                        $data[$count]['num'] = $count + 1;
                        $data[$count]['id'] = 1 ;
                        $data[$count]['trabajador'] = 'No existe';
                        $data[$count]['horas_estimadas'] = $tarea->estimated_time;
                        $data[$count]['horas_reales'] = $tarea->real_time;
                        $data[$count]['status'] = $tarea->task_status_id;
                        $data[$count]['task_id'] = $tarea->id;
                        $count++;
                    } else {
                        $data[$count]['num'] = $count + 1;
                        $data[$count]['id'] = $trabajador->id ;
                        $data[$count]['trabajador'] = $trabajador->name;
                        $data[$count]['horas_estimadas'] = $tarea->estimated_time;
                        $data[$count]['horas_reales'] = $tarea->real_time;
                        $data[$count]['status'] = $tarea->task_status_id;
                        $data[$count]['task_id'] = $tarea->id;
                        $count++;
                    }
                }
            }
        }
        return view('tasks.edit', compact('task', 'prioritys', 'employees', 'data', 'status'));
    }

    public function update(Request $request)
    {
        $loadTask = Task::find($request->taskId);
        for ($i = 1; $i <= $request['numEmployee']; $i++) {
            $exist = Task::find($request['taskId' . $i]);
            if ($exist) {
                $exist->admin_user_id = $request['employeeId' . $i];
                $exist->estimated_time = $request['estimatedTime' . $i];
                $exist->real_time = $request['realTime' . $i];
                $exist->priority_id = $request['priority'];
                $exist->task_status_id = $request['status' . $i];

                $exist->save();
            } else {
                if ($request['employeeId' . $i]) {
                    $data['admin_user_id'] = $request['employeeId' . $i];
                    $data['gestor_id'] = $loadTask->gestor_id;
                    $data['priority_id'] = $request['priority'];
                    $data['project_id'] = $loadTask->project_id;
                    $data['budget_id'] = $loadTask->budget_id;
                    $data['budget_concept_id'] = $loadTask->budget_concept_id;
                    $data['task_status_id'] = $request['status' . $i] ?? 2;
                    $data['split_master_task_id'] = $loadTask->id;
                    $data['duplicated'] = 0;
                    $data['description'] = $request['description'];
                    $data['title'] = $request['title'];
                    $data['estimated_time'] = $request['estimatedTime' . $i];
                    $data['real_time'] = $request['realTime' . $i] ?? '00:00:00';

                    $newtask = Task::create($data);
                    $taskSaved = $newtask->save();
                }
            }
        }
        $loadTask->title = $request['title'];
        $loadTask->description = $request['description'];
        $loadTask->duplicated = 1;
        $loadTask->save();

        return redirect()->route('tarea.edit',$loadTask->id)->with('toast',[
            'icon' => 'success',
            'mensaje' => 'Tarea actualizada'
        ]);
    }

    public function calendar($id)
    {
        $user = User::where('id', $id)->first();

        // Obtener los eventos de tareas para el usuario
        $events = $this->getLogTasks($id);
        // Convertir los eventos en formato adecuado para FullCalendar (si no están ya en ese formato)
        $eventData = [];
        foreach ($events as $event) {

            $inicio = Carbon::createFromFormat('Y-m-d H:i:s', $event[1], 'UTC');
            $inicioEspaña = $inicio->setTimezone('Europe/Madrid');
            if(isset($event[2])){
                $fin = Carbon::createFromFormat('Y-m-d H:i:s', $event[2], 'UTC');
                $finEspaña = $fin->setTimezone('Europe/Madrid');
            }

            $eventData[] = [
                'id' => $event[3],
                'title' => $event[0],
                'start' => $inicioEspaña->toIso8601String(), // Aquí debería estar la fecha y hora de inicio
                'end' => $event[2] ? $finEspaña->toIso8601String() : null , // Aquí debería estar la fecha y hora de fin
                'allDay' => false, // Indica si el evento es de todos los días
                'color' =>$event[4]
            ];
        }
        // Datos adicionales de horas trabajadas y producidas
        $horas = $this->getHorasTrabajadas($user);
        $horas_hoy = $this->getHorasTrabajadasHoy($user);
        $horas_hoy2 = $this->getHorasTrabajadasHoy2($user);
        $horas_dia = $this->getHorasTrabajadasDia($user);

        // Pasar los datos de eventos a la vista como JSON
        return view('tasks.timeLine', [
            'user' => $user,
            'horas' => $horas,
            'horas_hoy' => $horas_hoy,
            'horas_dia' => $horas_dia,
            'horas_hoy2' => $horas_hoy2,
            'events' => $eventData // Enviar los eventos como JSON
        ]);
    }


    public function getHorasTrabajadasDia($usuario)
    {
        $horasTrabajadas = DB::select("SELECT SUM(TIMESTAMPDIFF(MINUTE,date_start,date_end)) AS minutos FROM log_tasks where date_start >= cast(now() As Date) AND `admin_user_id` = $usuario->id");
        $hora = floor($horasTrabajadas[0]->minutos / 60);
        $minuto = ($horasTrabajadas[0]->minutos % 60);
        $horas_dia = $hora . ' Horas y ' . $minuto . ' minutos';

        return $horas_dia;
    }

    public function getHorasTrabajadas($usuario)
    {
        $horasTrabajadas = DB::select("SELECT SUM(TIMESTAMPDIFF(MINUTE,date_start,date_end)) AS minutos FROM `log_tasks` WHERE date_start BETWEEN now() - interval (day(now())-1) day AND LAST_DAY(NOW()) AND `admin_user_id` = $usuario->id");
        $hora = floor($horasTrabajadas[0]->minutos / 60);
        $minuto = ($horasTrabajadas[0]->minutos % 60);
        $horas = $hora . ' Horas y ' . $minuto . ' minutos';

        return $horas;
    }

    // Horas producidas hoy
    public function getHorasTrabajadasHoy($user)
    {
        // Se obtiene los datos
        $id = $user->id;
        $fecha = Carbon::now()->toDateString();;
        $resultado = 0;
        $totalMinutos2 = 0;

        $logsTasks = LogTasks::where('admin_user_id', $id)
        ->whereDate('date_start', '=', $fecha)
        ->get();

        foreach($logsTasks as $item){
            if($item->date_end == null){
                $item->date_end = Carbon::now();
            }
            $to_time2 = strtotime($item->date_start);
            $from_time2 = strtotime($item->date_end);
            $minutes2 = ($from_time2 - $to_time2) / 60;
            $totalMinutos2 += $minutes2;
        }

        $hora2 = floor($totalMinutos2 / 60);
        $minuto2 = ($totalMinutos2 % 60);
        $horas_dia2 = $hora2 . ' Horas y ' . $minuto2 . ' minutos';

        $resultado = $horas_dia2;

        return $resultado;
    }

    // Horas trabajadas hoy
    public function getHorasTrabajadasHoy2($user)
    {
         // Se obtiene los datos
         $id = $user->id;
         $fecha = Carbon::now()->toDateString();
         $hoy = Carbon::now();
         $resultado = 0;
         $totalMinutos2 = 0;


        $almuerzoHoras = 0;

        $jornadas = Jornada::where('admin_user_id', $id)
        ->whereDate('start_time', $hoy)
        ->get();

        $totalWorkedSeconds = 0;
        foreach($jornadas as $jornada){
            $workedSeconds = Carbon::parse($jornada->start_time)->diffInSeconds($jornada->end_time ?? Carbon::now());
            $totalPauseSeconds = $jornada->pauses->sum(function ($pause) {
                return Carbon::parse($pause->start_time)->diffInSeconds($pause->end_time ?? Carbon::now());
            });
            $totalWorkedSeconds += $workedSeconds - $totalPauseSeconds;
        }
        $horasTrabajadasFinal = $totalWorkedSeconds / 60;

        $hora = floor($horasTrabajadasFinal / 60);
        $minuto = ($horasTrabajadasFinal % 60);

        $horas_dia = $hora . ' Horas y ' . $minuto . ' minutos';

        return $horas_dia;
    }

    public function getLogTasks($idUsuario)
    {
        $events = [];
        $logs = LogTasks::where("admin_user_id", $idUsuario)->get();
        $end = Carbon::now()->format('Y-m-d H:i:s');
        $now = Carbon::now()->format('Y-m-d H:i:s');


        foreach ($logs as $index => $log) {

           $fin = $now;

           if ($log->date_end == null) {
                $nombre = isset($log->tarea->presupuesto->cliente->name) ? $log->tarea->presupuesto->cliente->name : 'El cliente no tiene nombre o no existe';

                $events[] =[
                    "Titulo: " . $log->tarea->title . "\n " . "Cliente: " . $nombre,
                    $log->date_start,
                    $fin,
                    $log->task_id,
                    '#FD994E'

                ];
            } else {
                $nombre = isset($log->tarea->presupuesto->cliente->name) ? $log->tarea->presupuesto->cliente->name : 'El cliente no tiene nombre o no existe';
                $events[] = [
                    "Titulo: " . $log->tarea->title . "\n " . "Cliente: " . $nombre,
                    $log->date_start,
                    $log->date_end,
                    $log->task_id,
                    '#FD994E'

                ];
            }
        }
        return $events;
    }

    public function destroy(Request $request)
    {
        $tarea = Task::find($request->id);

        if (!$tarea) {
            return response()->json([
                'status' => false,
                'mensaje' => "Error en el servidor, intentelo mas tarde."
            ]);
        }

        $tarea->delete();
        return response()->json([
            'status' => true,
            'mensaje' => 'El tarea borrada correctamente'
        ]);
    }


    public function setStatusTask(Request $request)
    {



        $tarea = Task::find($request->id);
        $date = Carbon::now();

        $formatEstimated = strtotime($tarea->estimated_time);
        $formatReal = strtotime($tarea->real_time);


        $error = false;


        //if($clientIP == "81.45.82.225" || $usuario->access_level_id == 4 || $usuario->access_level_id == 3){

        if ($tarea) {
            switch ($request->estado) {
                case "Reanudar":
                    // $tareaActiva = Task::where("admin_user_id", $usuario->id)->where("task_status_id", 1)->get()->first();

                    // if (!$tareaActiva) {
                    //     $tarea->task_status_id = 1;
                    // }

                    $logTaskC = DB::select("SELECT id FROM `log_tasks` WHERE `status` = 'Reanudada' AND `task_id` = $tarea->id");
                    if (count($logTaskC) == 1) {
                        $error = true;
                    } else {


                        $createLog = LogTasks::create([
                            'admin_user_id' => $tarea->admin_user_id,
                            'task_id' => $tarea->id,
                            'date_start' => $date,
                            'date_end' => null,
                            'status' => 'Reanudada'
                        ]);

                        // if ($tarea->real_time > $tarea->estimated_time) {
                        //     // Calcular el porcentaje de exceso

                        //     list($realHours, $realMinutes, $realSeconds) = explode(':', $tarea->real_time);
                        //     $realTimeInSeconds = ($realHours * 3600) + ($realMinutes * 60) + $realSeconds;

                        //     list($estimatedHours, $estimatedMinutes, $estimatedSeconds) = explode(':', $tarea->estimated_time);
                        //     $estimatedTimeInSeconds = ($estimatedHours * 3600) + ($estimatedMinutes * 60) + $estimatedSeconds;

                        //     // Calcular el porcentaje de exceso basado en segundos
                        //     $exceedPercentage = ($realTimeInSeconds / $estimatedTimeInSeconds) * 100;

                        //     // Inicializar datos comunes de la alerta
                        //     $data = [
                        //         "admin_user_id" => $tarea->gestor_id,
                        //         "status_id" => 1,
                        //         "reference_id" => $tarea->id,
                        //         "activation_datetime" => Carbon::now()
                        //     ];

                            // Definir el mensaje y el stage_id según el porcentaje de exceso
                            // if ($exceedPercentage >= 100) {
                            //     $data["stage_id"] = 40; // Stage para el 100% de sobrepaso
                            //     $data["description"] = 'Tarea ' . $tarea->id.' '.$tarea->title .' ha sobrepasado las horas estimadas en un 100% o más (pérdidas)';
                            // } elseif ($exceedPercentage >= 50) {
                            //     $data["stage_id"] = 40; // Stage para el 50% de sobrepaso
                            //     $data["description"] = 'Tarea ' . $tarea->id.' '.$tarea->title .' está sobrepasando las horas estimadas en un 50%';
                            // } else {
                            //     $data["stage_id"] = 40; // Stage para sobrepaso menor al 50%
                            //     $data["description"] = 'Aviso de Tarea - Se está sobrepasando las horas estimadas en la tarea ' . $tarea->title;
                            // }

                            // $existe = Alert::where('stage_id', $data["stage_id"]) ->where('reference_id', $tarea->id)->where('description', $data["description"])->exists();
                            // // Crear y guardar la alerta
                            // if (!$existe) {
                            //     $alert = Alert::create($data);
                            //     $alertSaved = $alert->save();
                            // }
                        // }


                        // $logTask = DB::select("SELECT id FROM `log_tasks` WHERE date_start BETWEEN DATE_SUB(now(), interval 6 hour) AND DATE_ADD(NOW(), INTERVAL 7 hour) AND `task_id` = $tarea->id");
                        // if (count(value: $logTask) == 1) {

                        //     $activeJornada = $usuario->activeJornada();

                        //     if (!$activeJornada) {
                        //         $jornada =  Jornada::create([
                        //             'admin_user_id' => $usuario->id,
                        //             'start_time' => Carbon::now(),
                        //             'is_active' => true,
                        //         ]);
                        //     }

                        //     $horaLimiteEntrada = Carbon::createFromTime(9, 30, 0, 'Europe/Madrid');
                        //     $horaLimiteEntradaUTC = $horaLimiteEntrada->setTimezone('UTC');
                        //     $mesActual = Carbon::now()->month;
                        //     $añoActual = Carbon::now()->year;
                        //     $fechaActual = Carbon::now();

                        //     $todayJornada = Jornada::where('admin_user_id', $usuario->id)
                        //     ->whereDate('start_time', $fechaActual->toDateString())
                        //     ->whereTime('start_time', '>', $horaLimiteEntradaUTC->format('H:i:s'))
                        //     ->get();


                        //     $hourlyAverage = Jornada::where('admin_user_id', $usuario->id)
                        //         ->whereMonth('start_time', $mesActual)
                        //         ->whereYear('start_time', $añoActual)
                        //         ->whereRaw("TIME(start_time) > ?", [$horaLimiteEntradaUTC->format('H:i:s')])
                        //         ->get();




                        //     $fechaNow = Carbon::now();

                        //     if(count($todayJornada) > 0){

                        //         if (count($hourlyAverage) > 2) {
                        //             $alertados = [1,8];
                        //             foreach($alertados as $alertar){
                        //                 $data = [
                        //                     "admin_user_id" =>  $alertar,
                        //                     "stage_id" => 23,
                        //                     "description" => $usuario->name . " ha llegado tarde 3 veces o mas este mes",
                        //                     "status_id" => 1,
                        //                     "reference_id" => $usuario->id,
                        //                     "activation_datetime" => Carbon::now()->format('Y-m-d H:i:s')
                        //                 ];

                        //                 $alert = Alert::create($data);
                        //                 $alertSaved = $alert->save();
                        //             }
                        //         }

                        //         switch (count($hourlyAverage)) {
                        //             case 1:
                        //                 $text = 'Hemos notado que hoy llegaste después de la hora límite de entrada (09:30). Entendemos que a veces pueden surgir imprevistos, pero te recordamos la importancia de respetar el horario para mantener la eficiencia en el equipo.';
                        //                 break;
                        //             case 2:
                        //                 $text = 'Nuevamente has llegado después de la hora límite de entrada (09:30). Reforzamos la importancia de cumplir con el horario para asegurar un buen rendimiento y organización en el equipo.';
                        //                 break;
                        //             case 3:
                        //                 $text = 'Se ha registrado tu llegada tarde tres veces. Esta información se compartirá con la Dirección. Es importante respetar los horarios para mantener el rendimiento y la organización del equipo.';
                        //                 break;
                        //             default:
                        //                 $text = 'Se ha registrado tu llegada tarde mas de  tres veces. Esta información se compartirá con la Dirección. Es importante respetar los horarios para mantener el rendimiento y la organización del equipo.';
                        //                 break;
                        //         }

                        //         $data = [
                        //             "admin_user_id" =>  $usuario->id,
                        //             "stage_id" => 23,
                        //             "description" => $text,
                        //             "status_id" => 1,
                        //             "reference_id" => $usuario->id,
                        //             "activation_datetime" => $fechaNow->format('Y-m-d H:i:s')
                        //         ];

                        //         $alert = Alert::create($data);
                        //         $alertSaved = $alert->save();
                        //     }

                        // }
                        $tarea->task_status_id = 1;
                    }
                    break;
                case "Pausada":
                    if ($tarea->task_status_id == 1) {
                        if ($tarea->real_time == "00:00:00") {
                            $start = $tarea->updated_at;
                            $end   = new \DateTime("NOW");
                            $interval = $end->diff($start);

                            $time = sprintf(
                                '%02d:%02d:%02d',
                                ($interval->d * 24) + $interval->h,
                                $interval->i,
                                $interval->s
                            );
                        } else {
                            $start = $tarea->updated_at;
                            $end   = new \DateTime("NOW");
                            $interval = $end->diff($start);

                            $time = sprintf(
                                '%02d:%02d:%02d',
                                ($interval->d * 24) + $interval->h,
                                $interval->i,
                                $interval->s
                            );

                            $time = $this->sum_the_time($tarea->real_time, $time);
                        }
                        $tarea->real_time = $time;
                    }

                    $last = LogTasks::where("admin_user_id", $tarea->admin_user_id)->get()->last();
                    if ($last) {
                        $last->date_end = $date;
                        $last->status = "Pausada";
                        $last->save();
                    }

                    $tarea->task_status_id = 2;
                    break;
                case "Finalizada":

                    //Crear Alerta tarea terminada antes de tiempo
                    // if ($formatEstimated > $formatReal) {
                    //     $dataAlert = [
                    //         'admin_user_id' => $usuario->id,
                    //         'stage_id' => 14,
                    //         'activation_datetime' => $date->format('Y-m-d H:i:s'),
                    //         'status_id' => 1,
                    //         'reference_id' => $tarea->id,
                    //     ];

                    //     $alert = Alert::create($dataAlert);
                    //     $alertSaved = $alert->save();
                    // }

                    //revisar antes que la tarea este pausada
                    if($tarea->task_status_id == 2){
                        $tarea->task_status_id = 5;
                    }


                    break;
            }

            $taskSaved = $tarea->save();


            if (($taskSaved || $tareaActiva == null) && !$error) {
                return response()->json(['estado' => 'OK'], 200);

            } else {
                $response = json_encode(array(
                    "estado" => "ERROR; TIENES OTRA TAREA ACTIVA. HABLA CON EL CREADOR .` . $error,"
                ));
            }
        } else {
            $response = json_encode(array(
                "estado" => "ERROR"
            ));
        }
        //}

        return $response;
    }

    function sum_the_time($time1, $time2)
    {
        $times = array($time1, $time2);
        $seconds = 0;
        foreach ($times as $time) {
            list($hour, $minute, $second) = explode(':', $time);
            $seconds += $hour * 3600;
            $seconds += $minute * 60;
            $seconds += $second;
        }
        $hours = floor($seconds / 3600);
        $seconds -= $hours * 3600;
        $minutes  = floor($seconds / 60);
        $seconds -= $minutes * 60;
        // return "{$hours}:{$minutes}:{$seconds}";
        return sprintf('%02d:%02d:%02d', $hours, $minutes, $seconds);
    }

    function convertToNumber($importe) {
        // Elimina los puntos de separación de miles
        $importe = str_replace('.', '', $importe);
        // Reemplaza la coma decimal por un punto decimal
        $importe = str_replace(',', '.', $importe);
        // Convierte a número flotante
        return (float)$importe;
    }




}
