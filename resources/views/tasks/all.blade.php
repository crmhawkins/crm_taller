@extends('layouts.app')

@section('titulo', 'Tareas')

@section('content')

<div class="page-heading card" style="box-shadow: none !important">
    @if(Auth::user()->access_level_id != 12)
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
    @endif
    <div class="ambas-tablas">


        <section class="section pt-4">
            <div class="card">
                <div class="card-body">
                    <div class="col-12 d-flex align-items-center justify-items-center mb-4">
                        <img src={{asset('assets/images/logo/logo.png') }} alt="Logo" style="height: 150px; margin-right: 15px;">
                        <h2 class="mb-0 display-2">Producción</h2>
                    </div>
                    <button id="toggleFullscreen" class="btn btn-secondary btn-lg mb-3">Pantalla Completa</button>
                    <button id="userPinButton" class="btn btn-primary btn-lg mb-3">Jornada</button>

                    <div id="tableContainer" class="table-responsive">
                        <table class="custom-table">
                            <thead>
                                <tr>
                                    <th>Título</th>
                                    <th>Tiempo Estimado</th>
                                    <th>Tiempo Real</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody id="tasksTableBodyEstado1y2">
                                @foreach($tareas as $tarea)
                                    @if($tarea->estado->id == 1 || $tarea->estado->id == 2)
                                        <tr class="estado-{{ str_replace(' ', '', strtolower($tarea->estado->name)) }}">
                                            <td>{{ $tarea->title }}</td>
                                            <td>{{ $tarea->estimated_time }}</td>
                                            <td class="real-time">{{ $tarea->real_time }}</td>
                                            <td>
                                                @if($tarea->usuario)
                                                        <button class="btn btn-success start-task" data-task-id="{{ $tarea->id }}">
                                                            <i class="bi bi-play-fill"></i>
                                                        </button>
                                                        <button class="btn btn-warning pause-task" data-task-id="{{ $tarea->id }}">
                                                            <i class="bi bi-pause-fill"></i>
                                                        </button>
                                                    @if($tarea->estado->name == 'Pausada')
                                                        <button class="btn btn-danger finish-task" data-task-id="{{ $tarea->id }}">
                                                            <i class="bi bi-stop-fill"></i>
                                                        </button>
                                                    @endif
                                                @endif
                                                <button class="btn btn-info view-details" data-task-id="{{ $tarea->id }}" data-bs-toggle="modal" data-bs-target="#detallesModal">
                                                    <i class="fa-solid fa-info"></i>
                                                </button>
                                                {{-- @if(!isset($tarea->admin_user_id))
                                                    <button class="btn btn-secondary assign-user" data-task-id="{{ $tarea->id }}" data-bs-toggle="modal" data-bs-target="#assignUserModal">
                                                        Asignar
                                                    </button>
                                                @endif --}}
                                            </td>
                                        </tr>
                                        @if ($tarea->empleados->count() > 0)
                                            <tr class="bg-light texto-negro">
                                                <td colspan="5">
                                                    <strong>Empleados activos:</strong>
                                                    <ul class="mb-0">
                                                        @foreach($tarea->empleados as $empleado)
                                                            <li>
                                                                {{ $empleado->name }} {{ $empleado->surname }}
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                </td>
                                            </tr>
                                        @endif
                                    @endif
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </section>

        <!-- Nueva tabla para tareas con estados diferentes a 1 y 2 -->
        {{-- <div class="card mt-4">
            <div class="card-body">
                <h4>Tareas en Revisión</h4>
                <div class="table-responsive">
                    <table class="custom-table">
                        <thead>
                            <tr>
                                <th>Título</th>
                                <th>Estado</th>
                                <th>Tiempo Estimado</th>
                                <th>Tiempo Real</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody id="tasksTableBodyOtrosEstados">
                            @foreach($tareas as $tarea)
                                @if($tarea->estado->id != 1 && $tarea->estado->id != 2)
                                    <tr class="estado-{{ str_replace(' ', '', strtolower($tarea->estado->name)) }}">
                                        <td>{{ $tarea->title }}</td>
                                        <td>{{ $tarea->usuario->name ?? 'No asignado' }} {{$tarea->usuario->surname ?? ''}}</td>
                                        <td>{{ $tarea->estimated_time }}</td>
                                        <td>{{ $tarea->real_time }}</td>
                                        <td>
                                            @if($tarea->usuario)
                                                @if($tarea->estado->id != 1)
                                                    <button class="btn btn-success start-task" data-task-id="{{ $tarea->id }}">
                                                        <i class="bi bi-play-fill"></i>
                                                    </button>
                                                @endif
                                                @if($tarea->estado->id != 5 && $tarea->estado->id != 2)
                                                    <button class="btn btn-warning pause-task" data-task-id="{{ $tarea->id }}">
                                                        <i class="bi bi-pause-fill"></i>
                                                    </button>
                                                @endif
                                                @if($tarea->estado->id == 2)
                                                    <button class="btn btn-danger finish-task" data-task-id="{{ $tarea->id }}">
                                                        <i class="bi bi-stop-fill"></i>
                                                    </button>
                                                @endif
                                            @endif
                                            @if(!isset($tarea->admin_user_id))
                                                <button class="btn btn-secondary assign-user" data-task-id="{{ $tarea->id }}" data-bs-toggle="modal" data-bs-target="#assignUserModal">
                                                    Asignar
                                                </button>
                                            @endif
                                        </td>
                                    </tr>
                                @endif
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div> --}}
         <!-- Modal para asignar usuario -->
        <div class="modal fade" id="assignUserModal" tabindex="-1" aria-labelledby="assignUserModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="assignUserModalLabel">Asignar Usuario</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <input type="text" id="userSearchInput" class="form-control" placeholder="Introduce el pin del usuario...">
                        {{-- <button type="button" id="searchUserButton" class="btn btn-primary mt-2">Buscar</button> --}}
                        {{-- <ul id="userResults" class="list-group mt-2"></ul> --}}
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        <button type="button" class="btn btn-primary" id="assignUserButton">Asignar</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="userPinModal" tabindex="-1" aria-labelledby="userPinModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="userPinModalLabel">Ingresar PIN de Usuario</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <input type="text" id="userPinInput" class="form-control" placeholder="Ingrese su PIN">
                        <button type="button" id="validatePinButton" class="btn btn-primary mt-2">Validar PIN</button>
                        <div id="userMessage" class="mt-3"></div>
                        <div id="jornadaButtons" class="mt-3" style="display: none;">
                            <button type="button" id="startJornadaButton" class="btn btn-success">Iniciar Jornada</button>
                            <button type="button" id="endJornadaButton" class="btn btn-danger">Finalizar Jornada</button>
                        </div>
                        <table id="jornadasTable" class="table mt-3" style="display: none;">
                            <thead>
                                <tr>
                                    <th>Fecha de Inicio</th>
                                    <th>Fecha de Fin</th>
                                    <th>Estado</th>
                                    <th>Horas Trabajadas</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

            <!-- Modal para ingresar PIN -->
        <div class="modal fade" id="userValidatePinModal" tabindex="-1" aria-labelledby="userValidatePinModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="userValidatePinModalLabel">Ingresar PIN de Usuario</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <input type="text" id="uservalidatePinInput" class="form-control" placeholder="Ingrese su PIN">
                        <div id="userPinError" class="text-danger mt-2" style="display:none;">Por favor ingrese su PIN</div>
                        </div>
                        <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="button" id="uservalidatePinButton" class="btn btn-primary">Validar PIN</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="detallesModal" tabindex="-1" aria-labelledby="detallesModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="detallesModalLabel">Detalles de la tarea</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<!-- Incluir SweetAlert2 desde un CDN -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    let selectedUserId = null;
    let selectedTaskId = null;


    function showPinModal(taskId, action) {
        // Mostrar el modal de Bootstrap
        const myModal = new bootstrap.Modal(document.getElementById('userValidatePinModal'));
        myModal.show();

        // Agregar evento al botón de validación del PIN
        document.getElementById('uservalidatePinButton').onclick = function() {
            const pin = document.getElementById('uservalidatePinInput').value;

            // Validar si el PIN está vacío
            if (!pin) {
                document.getElementById('userPinError').style.display = 'block'; // Mostrar el mensaje de error
            } else {
                document.getElementById('userPinError').style.display = 'none'; // Ocultar el mensaje de error

                // Llamar a la función para validar el PIN
                executeTaskAction(action, taskId, pin);

                //validatePin(pin, action, taskId);
                document.getElementById('uservalidatePinInput').value = ''; // Limpiar el campo de entrada
                // Cerrar el modal después de la validación
                myModal.hide();
            }
        };
    }

    function validatePin(pin, action, taskId) {
    // Llamada para validar el PIN enviando tanto el PIN como el ID de la tarea
        fetch('/users/validate-pin', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                pin: pin,
                taskId: taskId
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.valid) {
                // Si el PIN es válido, ejecutar la acción de la tarea
                executeTaskAction(action, taskId, pin);
            } else {
                // Si el PIN es incorrecto
                Swal.fire('Error', 'PIN inválido. Intente de nuevo.', 'error');
            }
        })
        .catch(error => {
            Swal.fire('Error', 'Error al validar el PIN.', 'error');
            console.error('Error:', error);
        });
    }

    function executeTaskAction(action, taskId, pin) {
        switch (action) {
            case 'Reanudar':
                changeTaskStatus(taskId, 'Reanudar', pin);
                break;
            case 'Pausada':
                changeTaskStatus(taskId, 'Pausada' , pin);
                break;
            case 'Finalizada':
                changeTaskStatus(taskId, 'Finalizada', pin);
                break;
        }
    }



    document.getElementById('toggleFullscreen').addEventListener('click', function() {
        const pageContainer = document.querySelector('.ambas-tablas');
        if (!document.fullscreenElement) {
            pageContainer.requestFullscreen().catch(err => {
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
                const tbodyEstado1y2 = document.getElementById('tasksTableBodyEstado1y2');
                tbodyEstado1y2.innerHTML = ''; // Limpiar el contenido actual

                data.forEach(tarea => {
                    if (tarea.estado && (tarea.estado.id == 1 || tarea.estado.id == 2)) {
                        const row = document.createElement('tr');
                        row.className = 'estado-' + (tarea.estado ? tarea.estado.name.replace(/\s+/g, '').toLowerCase() : 'sin-estado');

                        let actionButtons = '';
                        if (tarea.usuario) {

                                actionButtons += `
                                    <button class="btn btn-success start-task" data-task-id="${tarea.id}">
                                        <i class="bi bi-play-fill"></i>
                                    </button>
                                `;


                                actionButtons += `
                                    <button class="btn btn-warning pause-task" data-task-id="${tarea.id}">
                                        <i class="bi bi-pause-fill"></i>
                                    </button>
                                `;

                            if (tarea.task_status_id && tarea.task_status_id === 2) {
                                actionButtons += `
                                    <button class="btn btn-danger finish-task" data-task-id="${tarea.id}">
                                        <i class="bi bi-stop-fill"></i>
                                    </button>
                                `;
                            }
                            actionButtons += `
                                <button class="btn btn-info view-details" data-task-id="${tarea.id}" data-bs-toggle="modal" data-bs-target="#detallesModal">
                                    <i class="fa-solid fa-info"></i>
                                </button>
                            `;
                        }

                        row.innerHTML = `
                            <td>${tarea.title}</td>
                            <td>${tarea.estimated_time}</td>
                            <td class="real-time">${tarea.real_time}</td>
                            <td>${actionButtons}</td>
                        `;

                        tbodyEstado1y2.appendChild(row);

                        // Fila de empleados activos
                        if (tarea.empleados && tarea.empleados.length > 0) {
                            const empleadosRow = document.createElement('tr');
                            empleadosRow.className = 'bg-light texto-negro';
                            empleadosRow.innerHTML = `
                                <td colspan="4">
                                    <strong>Empleados activos:</strong>
                                    <ul class="mb-0">
                                        ${tarea.empleados.map(emp => `<li>${emp.name} ${emp.surname}</li>`).join('')}
                                    </ul>
                                </td>
                            `;
                            tbodyEstado1y2.appendChild(empleadosRow);
                        }
                    }
                });

                attachEventListeners(); // Reasignar eventos
                marcarTareasFueraDeTiempo();
            })
            .catch(error => {
                console.error('Error al actualizar las tareas:', error);
            });
    }


    function changeTaskStatus(taskId, estado, pin) {
        fetch(`/tasks/set-status`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ id: taskId, estado: estado , pin: pin})
        })
        .then(response => response.json())
        .then(data => {
            if (data.estado == 'OK') {
                // Swal.fire('Éxito', data.message, 'success');
                fetchTasks(); // Actualizar la tabla sin recargar
            } else {
                // Swal.fire('Error', data.estado, 'error');
            }
        })
        .catch(error => {
            Swal.fire('Error', 'Error al procesar la solicitud.', 'error');
            console.error('Error:', error);
        });
    }

    function fetchTaskDetails(taskId) {
        fetch(`/tasks/details/${taskId}`, {
            method: 'POST',  // Cambia el método a POST
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')  // Asegúrate de que el token CSRF esté incluido en las cabeceras
            },
            body: JSON.stringify({ id: taskId })  // Aunque no es necesario enviar un body para este caso, se incluye como ejemplo
        })
        .then(response => {
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            return response.json();
        })
        .then(data => {
            const modalBody = document.querySelector('#detallesModal .modal-body');
            modalBody.innerHTML = `<p><strong>Título:</strong> ${data.title}</p>
                                    <p><strong>Descripción:</strong> ${data.description}</p>`;
        })
        .catch(error => console.error('Error al cargar detalles:', error));
    }
    // Asegúrate de que esta función esté definida antes de que se llame en attachEventListeners
    function attachEventListeners() {
        // Reasignar event listeners para los botones de las tareas
        document.querySelectorAll('.start-task').forEach(button => {
            button.addEventListener('click', function() {
                const taskId = this.getAttribute('data-task-id');


                showPinModal(taskId ,'Reanudar' );
                //changeTaskStatus(taskId, 'Reanudar');
                // startRealTimeCounter(taskId);
            });
        });

        document.querySelectorAll('.pause-task').forEach(button => {
            button.addEventListener('click', function() {
                const taskId = this.getAttribute('data-task-id');
                showPinModal(taskId, 'Pausada');
                // stopRealTimeCounter(taskId);
            });
        });

        document.querySelectorAll('.finish-task').forEach(button => {
            button.addEventListener('click', function() {
                const taskId = this.getAttribute('data-task-id');
                showPinModal(taskId, 'Finalizada');
                // stopRealTimeCounter(taskId);
            });
        });

        document.querySelectorAll('.assign-user').forEach(button => {
            button.addEventListener('click', function() {
                selectedTaskId = this.getAttribute('data-task-id');
            });
        });

        document.querySelectorAll('.view-details').forEach(button => {
            button.addEventListener('click', function() {
                const taskId = this.getAttribute('data-task-id');
                fetchTaskDetails(taskId); // Llamar a la función para cargar detalles
            });
        });
    }

    // Inicializar los event listeners al cargar la página
    document.addEventListener('DOMContentLoaded', attachEventListeners);


    document.addEventListener('DOMContentLoaded', function() {
        const userSearchInput = document.getElementById('userSearchInput');
        const searchUserButton = document.getElementById('searchUserButton');
        const userResults = document.getElementById('userResults');
        var userModal = new bootstrap.Modal(document.getElementById('assignUserModal'));

        document.querySelectorAll('.assign-user').forEach(button => {
            button.addEventListener('click', function() {
                selectedTaskId = this.getAttribute('data-task-id');
            });
        });

        // searchUserButton.addEventListener('click', function() {
        //     const query = userSearchInput.value;
        //     if (query.length >= 1) {
        //         fetch(`{{ route("users.search") }}?q=${query}`)
        //             .then(response => response.json())
        //             .then(data => {
        //                 userResults.innerHTML = '';
        //                 data.forEach(user => {
        //                     const listItem = document.createElement('li');
        //                     listItem.className = 'list-group-item';
        //                     listItem.textContent = user.name;
        //                     listItem.dataset.userId = user.id;
        //                     listItem.addEventListener('click', function() {
        //                         selectedUserId = this.dataset.userId;
        //                         userResults.querySelectorAll('li').forEach(item => item.classList.remove('active'));
        //                         this.classList.add('active');
        //                     });
        //                     userResults.appendChild(listItem);
        //                 });
        //             });
        //     }
        // });

        document.getElementById('assignUserButton').addEventListener('click', function() {
            if (userSearchInput.value && selectedTaskId) {
                fetch(`/tasks/assign/${selectedTaskId}/${userSearchInput.value}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        userSearchInput.value = ''; // Limpiar el campo de búsqueda
                        userModal.hide(); // Ocultar el modal de asignación de usuario
                        Swal.fire('Éxito', data.message, 'success');
                        fetchTasks(); // Actualizar la tabla
                    } else {
                        userSearchInput.value = ''; // Limpiar el campo de búsqueda
                        userModal.hide(); // Ocultar el modal de asignación de usuario
                        Swal.fire('Error', data.message, 'error');
                    }
                })
                .catch(error => {
                    userSearchInput.value = ''; // Limpiar el campo de búsqueda
                    userModal.hide(); // Ocultar el modal de asignación de usuario
                    Swal.fire('Error', 'Error al procesar la solicitud.', 'error');
                    console.error('Error:', error);


                });
            } else {
                userSearchInput.value = ''; // Limpiar el campo de búsqueda
                userModal.hide(); // Ocultar el modal de asignación de usuario
                Swal.fire('Error', 'Por favor, Introduce el pin del usuario y selecciona una tarea.', 'error');

            }
        });

        function changeTaskStatus(taskId, estado) {
            fetch(`/tasks/set-status`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ id: taskId, estado: estado })
            })
            .then(response => response.json())
            .then(data => {
                console.log(data);
                if (data.estado == 'OK') {
                    // Swal.fire('Éxito', data.message, 'success').then(() => {
                        fetchTasks(); // Recargar la página
                    // });
                } else {
                    // Swal.fire('Error', data.estado, 'error');
                }
            })
            .catch(error => {
                Swal.fire('Error', 'Error al procesar la solicitud.', 'error');
                console.error('Error:', error);
            });
        }

    });

    // Asegúrate de que el modal se muestre correctamente en pantalla completa
    document.addEventListener('DOMContentLoaded', function() {
        const modal = document.getElementById('assignUserModal');
        modal.addEventListener('shown.bs.modal', function () {
            if (document.fullscreenElement) {
                modal.style.position = 'fixed';
                modal.style.top = '50%';
                modal.style.left = '50%';
                modal.style.transform = 'translate(-50%, -50%)';
            }
        });
    });

    function startRealTimeCounter(taskId) {
        const row = document.querySelector(`tr[data-task-id="${taskId}"]`);
        const realTimeCell = row.querySelector('.real-time');
        let realTime = parseInt(row.getAttribute('data-real-time'), 10);

        const intervalId = setInterval(() => {
            realTime += 1;
            realTimeCell.textContent = formatTime(realTime);
            row.setAttribute('data-real-time', realTime);
        }, 1000);

        row.setAttribute('data-interval-id', intervalId);
    }

    function stopRealTimeCounter(taskId) {
        const row = document.querySelector(`tr[data-task-id="${taskId}"]`);
        const intervalId = row.getAttribute('data-interval-id');
        if (intervalId) {
            clearInterval(intervalId);
            row.removeAttribute('data-interval-id');
        }
    }

    function formatTime(seconds) {
        const hours = Math.floor(seconds / 3600);
        const minutes = Math.floor((seconds % 3600) / 60);
        const secs = seconds % 60;
        return `${hours.toString().padStart(2, '0')}:${minutes.toString().padStart(2, '0')}:${secs.toString().padStart(2, '0')}`;
    }



    document.getElementById('userPinButton').addEventListener('click', function() {
        const userPinModal = new bootstrap.Modal(document.getElementById('userPinModal'));
        userPinModal.show();
    });

    document.getElementById('validatePinButton').addEventListener('click', function() {
        const pin = document.getElementById('userPinInput').value;
        fetch(`/users/validate-pin/${pin}`)
            .then(response => response.json())
            .then(data => {
                const userMessage = document.getElementById('userMessage');
                const jornadasTable = document.getElementById('jornadasTable');
                const tbody = jornadasTable.querySelector('tbody');
                tbody.innerHTML = ''; // Limpiar la tabla

                if (data.valid) {
                    data.jornadas.forEach(jornada => {
                        const row = document.createElement('tr');
                        const startTime = new Date(jornada.start_time).toLocaleString();
                        const endTime = jornada.end_time ? new Date(jornada.end_time).toLocaleString() : 'En progreso';
                        const estado = jornada.is_active ? 'Activa' : 'Finalizada';

                        row.innerHTML = `
                            <td>${startTime}</td>
                            <td>${endTime}</td>
                            <td>${estado}</td>
                            <td>${jornada.worked_hours}</td>
                        `;
                        tbody.appendChild(row);
                    });

                    // Agregar fila para el total
                    const totalRow = document.createElement('tr');
                    totalRow.innerHTML = `
                        <td colspan="3"><strong>Total</strong></td>
                        <td><strong>${data.totalWorkedHours}</strong></td>
                    `;
                    tbody.appendChild(totalRow);

                    jornadasTable.style.display = 'table';
                    userMessage.textContent = `¡Hola ${data.userName}! Aquí están tus jornadas:`;
                    document.getElementById('jornadaButtons').style.display = 'block';
                } else {
                    userMessage.textContent = 'PIN inválido.';
                    jornadasTable.style.display = 'none';
                    document.getElementById('jornadaButtons').style.display = 'none';
                }
            })
            .catch(error => {
                console.error('Error:', error);
                document.getElementById('userMessage').textContent = 'Error al validar el PIN.';
            });
    });

    document.getElementById('startJornadaButton').addEventListener('click', function() {
        const pin = document.getElementById('userPinInput').value;
        fetch('/jornada/start', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ pin: pin })
        })
        .then(response => response.json())
        .then(data => {
            document.getElementById('userMessage').textContent = data.message;
            if (data.success) {
                document.getElementById('jornadaButtons').style.display = 'none';
            }
        })
        .catch(error => {
            console.error('Error:', error);
            document.getElementById('userMessage').textContent = 'Error al iniciar la jornada.';
        });
    });

    document.getElementById('endJornadaButton').addEventListener('click', function() {
        const pin = document.getElementById('userPinInput').value;
        fetch('/jornada/end', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ pin: pin })
        })
        .then(response => response.json())
        .then(data => {
            document.getElementById('userMessage').textContent = data.message;
            if (data.success) {
                document.getElementById('jornadaButtons').style.display = 'none';
            }
        })
        .catch(error => {
            console.error('Error:', error);
            document.getElementById('userMessage').textContent = 'Error al finalizar la jornada.';
        });
    });

    // Restablecer el estado del modal al cerrarlo
    document.getElementById('userPinModal').addEventListener('hidden.bs.modal', function () {
        document.getElementById('jornadaButtons').style.display = 'none';
        document.getElementById('userPinInput').value = ''; // Limpiar el campo de entrada del PIN
        document.getElementById('userMessage').textContent = ''; // Limpiar el mensaje
        const jornadasTable = document.getElementById('jornadasTable');
        jornadasTable.style.display = 'none'; // Ocultar la tabla
        const tbody = jornadasTable.querySelector('tbody');
        tbody.innerHTML = ''; // Limpiar el contenido de la tabla
    });



    function timeToSeconds(timeStr) {
        const [hours, minutes, seconds] = timeStr.split(':').map(Number);
        return hours * 3600 + minutes * 60 + seconds;
    }

    function marcarTareasFueraDeTiempo() {
        document.querySelectorAll('#tasksTableBodyEstado1y2 tr').forEach(row => {
            const estimated = row.cells[2].innerText.trim(); // Tiempo estimado
            const real = row.cells[3].innerText.trim();      // Tiempo real

            if (estimated && real && timeToSeconds(real) > timeToSeconds(estimated)) {
                row.style.backgroundColor = '#ff4d4d'; // Rojo claro
            }
        });
    }

    // Llamar después de renderizar las tareas
    document.addEventListener('DOMContentLoaded', () => {
        marcarTareasFueraDeTiempo();
    });
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
    .custom-table tbody tr.estado-pausada{
        background-color: #ffffff;

    }
    tr.estado-pausada td{
        color: black !important;
        text-shadow: none !important;
    }
    tr.texto-negro td , tr.texto-negro ul li{
        color: black !important;
        text-shadow: none !important;
    }

    td{
        font-weight: bold;
        color: white;
        text-shadow: 1px 1px 1px black;
    }
    .modal-backdrop {
    display: none !important;
    }
    .modal.show {
    z-index: 1050 !important; /* Asegura que el modal siempre esté por encima de otros elementos */
}
</style>

@endsection
