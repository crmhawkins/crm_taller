@extends('layouts.app')

@section('titulo', 'Tareas')

@section('content')

<div class="page-heading card" style="box-shadow: none !important">

    <div class="page-title card-body">
        <div class="row justify-content-between">
            <div class="col-sm-12 col-md-6 order-md-1 order-last row">
                <div class="col-auto">
                    <h3><i class="bi bi-globe-americas"></i> Todas las Tareas</h3>
                    <p class="text-subtitle text-muted">Listado de todas las tareas</p>
                </div>
                
            </div>
            <div class="col-sm-12 col-md-4 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Tareas</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <section class="section pt-4">
        <div class="card">
            <div class="card-body">
                <button id="toggleFullscreen" class="btn btn-secondary mb-3">Pantalla Completa</button>
                <div id="tableContainer" class="table-responsive">
                    <table class="custom-table">
                        <thead>
                            <tr>
                                <th>Título</th>
                                <th>Responsable</th>
                                <th>Estado</th>
                                <th>Tiempo Estimado</th>
                                <th>Tiempo Real</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody id="tasksTableBody">
                            @foreach($tareas as $tarea)
                            <tr class="estado-{{ str_replace(' ', '', strtolower($tarea->estado->name)) }}">
                                <td>{{ $tarea->title }}</td>
                                <td>{{ $tarea->usuario->name ?? 'No asignado' }}</td>
                                <td>{{ $tarea->estado->name ?? 'Sin estado' }}</td>
                                <td>{{ $tarea->estimated_time }}</td>
                                <td>{{ $tarea->real_time }}</td>
                                <td>
                                    <button class="btn btn-primary toggle-responsibility" data-task-id="{{ $tarea->id }}">
                                        {{ $tarea->usuario ? 'Liberar' : 'Tomar' }}
                                    </button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>

</div>

<!-- Incluir SweetAlert2 desde un CDN -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    document.getElementById('toggleFullscreen').addEventListener('click', function() {
        const tableContainer = document.getElementById('tableContainer');
        if (!document.fullscreenElement) {
            tableContainer.requestFullscreen().catch(err => {
                Swal.fire('Error', `Error al intentar entrar en modo de pantalla completa: ${err.message}`, 'error');
            });
        } else {
            document.exitFullscreen();
        }
    });

    function attachEventListeners() {
        document.querySelectorAll('.toggle-responsibility').forEach(button => {
            button.addEventListener('click', function() {
                const taskId = this.getAttribute('data-task-id');
                const action = this.textContent.trim() === 'Tomar' ? 'assign' : 'unassign';

                fetch(`/tasks/${action}/${taskId}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        Swal.fire('Éxito', data.message, 'success');
                        fetchTasks(); // Actualizar la tabla
                    } else {
                        Swal.fire('Error', data.message, 'error');
                    }
                })
                .catch(error => {
                    Swal.fire('Error', 'Error al procesar la solicitud.', 'error');
                    console.error('Error:', error);
                });
            });
        });
    }

    // Función para actualizar la tabla cada 10 segundos
    setInterval(function() {
        fetchTasks();
    }, 10000);

    function fetchTasks() {
       fetch('{{ route("tasks.json") }}')
           .then(response => {
               if (!response.ok) {
                   throw new Error('Network response was not ok');
               }
               return response.json();
           })
           .then(data => {
               const tbody = document.getElementById('tasksTableBody');
               tbody.innerHTML = ''; // Limpiar el contenido actual

               data.forEach(tarea => {
                   const row = document.createElement('tr');
                   row.className = 'estado-' + (tarea.estado ? tarea.estado.name.replace(/\s+/g, '').toLowerCase() : 'sin-estado');
                   row.innerHTML = `
                       <td>${tarea.title}</td>
                       <td>${tarea.usuario ? tarea.usuario.name : 'No asignado'}</td>
                       <td>${tarea.estado ? tarea.estado.name : 'Sin estado'}</td>
                       <td>${tarea.estimated_time}</td>
                       <td>${tarea.real_time}</td>
                       <td>
                           <button class="btn btn-primary toggle-responsibility" data-task-id="${tarea.id}">
                               ${tarea.usuario ? 'Liberar' : 'Tomar'}
                           </button>
                       </td>
                   `;
                   tbody.appendChild(row);
               });

               attachEventListeners(); // Reasignar los event listeners
           })
           .catch(error => {
               console.error('Error al actualizar las tareas:', error);
           });
   }

   // Inicializar los event listeners al cargar la página
   document.addEventListener('DOMContentLoaded', attachEventListeners);
</script>

<style>
    .custom-table {
        width: 100%;
        border-collapse: collapse;
        font-family: 'Arial', sans-serif;
        margin-top: 20px;
    }
    .custom-table th, .custom-table td {
        padding: 12px 15px;
        text-align: left;
    }
    .custom-table thead {
        background-color: #f8f9fa;
        border-bottom: 2px solid #dee2e6;
    }
    .custom-table tbody tr {
        border-bottom: 1px solid #dee2e6;
        transition: background-color 0.3s;
    }
    .custom-table tbody tr:hover {
        background-color: #f1f1f1;
    }
    .custom-table tbody tr.estado-pendiente {
        background-color: #fff3cd;
    }

    .custom-table tbody tr.estado-finalizada {
        background-color: #383733;
        color: white;
    }

    .custom-table tbody tr.estado-revisión {
        background-color: #b3d420;
    }

    .custom-table tbody tr.estado-cancelada {
        background-color: red;}
    .custom-table tbody tr.estado-reanudada {
        background-color: #10c240;
    }
    .custom-table tbody tr.estado-enprogreso {
        background-color: #d1ecf1;
    }
    .custom-table tbody tr.estado-completada {
        background-color: #d4edda;
    }
    .custom-table tbody tr.estado-pausada {
        background-color: #e96d77;
    }
</style>

@endsection
