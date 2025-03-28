<?php

namespace App\Models\Tasks;

use Carbon\CarbonInterval;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class Task extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'tasks';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'admin_user_id',
        'gestor_id',
        'priority_id',
        'project_id',
        'budget_id',
        'budget_concept_id',
        'task_status_id',
        'split_master_task_id',
        'duplicated',
        'title',
        'description',
        'estimated_time',
        'real_time',
        'total_time_budget',
    ];

     /**
     * Mutaciones de fecha.
     *
     * @var array
     */
    protected $dates = [
        'created_at', 'updated_at', 'deleted_at',
    ];

    public function usuario() {
        return $this->belongsTo(\App\Models\Users\User::class,'admin_user_id');
    }

    public function logTasks() {
        return $this->hasMany(LogTasks::class,'task_id');
    }

    public function gestor() {
        return $this->belongsTo(\App\Models\Users\User::class,'gestor_id');
    }

    public function prioridad() {
        return $this->belongsTo(\App\Models\Prioritys\Priority::class,'priority_id');
    }

    public function proyecto() {
        return $this->belongsTo(\App\Models\Projects\Project::class,'project_id');
    }

    public function presupuesto() {
        return $this->belongsTo(\App\Models\Budgets\Budget::class,'budget_id');
    }

    public function presupuestoConcepto() {
        return $this->belongsTo(\App\Models\Budgets\BudgetConcept::class,'budget_concept_id');
    }
    public function estado() {
        return $this->belongsTo(\App\Models\Tasks\TaskStatus::class,'task_status_id');
    }

    public function tareaMaestra() {
        return $this->belongsTo(\App\Models\Tasks\Task::class,'split_master_task_id','id');
    }

    public function taskSplits() {
        return $this->hasMany(\App\Models\Tasks\Task::class,'split_master_task_id');
    }

    public function real_time_maestra() {

        // Obtener todas las tareas hijas y sumar sus horas en segundos
        $totalSeconds = $this->taskSplits()->sum(DB::raw("TIME_TO_SEC(real_time)"));

        // Calcular horas, minutos y segundos manualmente
        $hours = floor($totalSeconds / 3600);
        $minutes = floor(($totalSeconds % 3600) / 60);
        $seconds = $totalSeconds % 60;

        // Formatear a HH:MM:SS
        return sprintf('%02d:%02d:%02d', $hours, $minutes, $seconds);
    }

    public function empleados()
    {
        return $this->belongsToMany(
            \App\Models\Users\User::class,
            'log_tasks',
            'task_id',
            'admin_user_id'
        )->withPivot('date_start', 'date_end');
    }


    public function horasPorEmpleado()
    {
        $resultados = [];

        foreach ($this->logTasks as $log) {
            if ($log->date_start && $log->date_end) {
                $segundos = strtotime($log->date_end) - strtotime($log->date_start);
                $empleadoId = $log->admin_user_id;

                // Asegurarse de que sólo se sume dentro de esta tarea
                if (!isset($resultados[$empleadoId])) {
                    $resultados[$empleadoId] = 0;
                }

                $resultados[$empleadoId] += $segundos;
            }
        }

        // Convertir a formato HH:MM:SS
        foreach ($resultados as $id => $segundos) {
            $horas = floor($segundos / 3600);
            $minutos = floor(($segundos % 3600) / 60);
            $segundosRestantes = $segundos % 60;
            $resultados[$id] = sprintf('%02d:%02d:%02d', $horas, $minutos, $segundosRestantes);
        }

        return $resultados;
    }

}
