@extends('layouts.app')

@section('titulo', 'Dashboard')

@section('css')
<link rel="stylesheet" href="{{asset('assets/vendors/choices.js/choices.min.css')}}" />
<link rel="stylesheet" href="{{asset('assets/css/dashboard.css')}}" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

@endsection

@section('content')
<div class="page-heading card" style="box-shadow: none !important">
    <div class="page-title card-body">
        <div class="row">
            <div class="col-12 col-md-4 order-md-1 order-last">
                <h3>Dashboard</h3>
            </div>
            <div class="col-12 col-md-8 order-md-2 order-first">
                <!-- Aquí puedes añadir más contenido si es necesario -->
            </div>
        </div>
    </div>

    <div class="card2 mt-4" style="background-color: white; padding: 50px;">
        <div class="card-body2">
            <div class="row">
                <div class="col-md-4">
                    <div class="card mb-3">
                        <div class="card-header">Clientes</div>
                        <div class="card-body">
                            <a href="{{ route('clientes.create') }}" class="btn btn-primary btn-block mt-2">
                                <i class="fas fa-user-plus"></i> Añadir Clientes
                            </a>
                            <a href="{{ route('clientes.index') }}" class="btn btn-primary btn-block mt-2">
                                <i class="fas fa-users"></i> Ver Clientes
                            </a>
                            <a href="{{ route('presupuestos.index') }}" class="btn btn-primary btn-block mt-2">
                                <i class="fas fa-file-invoice"></i> Ver Presupuestos
                            </a>       
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card mb-3">
                        <div class="card-header">Coches</div>
                        <div class="card-body">
                            
                            <a href="{{ route('coches.index') }}" class="btn btn-primary btn-block mt-2">
                                <i class="fas fa-car-side"></i> Ver Coches
                            </a>
                            <a href="{{ route('coches-sustitucion.index') }}" class="btn btn-primary btn-block mt-2">
                                <i class="fas fa-exchange-alt"></i> Ver Coches Sustitución
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card mb-3">
                        <div class="card-header">Tareas y Citas</div>
                        <div class="card-body">
                            <a href="{{ route('tarea.all') }}" class="btn btn-primary btn-block mt-2">
                                <i class="fas fa-tasks"></i> Ver Tareas
                            </a>
                            <a href="{{ route('appointments.calendar') }}" class="btn btn-primary btn-block mt-2">
                                <i class="fas fa-calendar-alt"></i> Ver Citas
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card mb-3">
                        <div class="card-header">Partes de Trabajo</div>
                        <div class="card-body">
                            <a href="{{ route('siniestro.index') }}" class="btn btn-primary btn-block mt-2">
                                <i class="fas fa-tools"></i> Ver Partes de Trabajo
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card mb-3">
                        <div class="card-header">Piezas</div>
                        <div class="card-body">
                            <a href="{{ route('piezas.index') }}" class="btn btn-primary btn-block mt-2">
                                <i class="fas fa-cogs"></i> Ver Piezas
                            </a>
                            <a href="{{ route('proveedores.index') }}" class="btn btn-primary btn-block mt-2">
                                <i class="fas fa-truck"></i> Ver Proveedores
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card mb-3">
                        <div class="card-header">Seguros</div>
                        <div class="card-body">
                            <a href="{{ route('seguro.index') }}" class="btn btn-primary btn-block mt-2">
                                <i class="fas fa-shield-alt"></i> Ver Seguros
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
@include('partials.toast')
<script src="{{asset('assets/vendors/choices.js/choices.min.js')}}"></script>
<script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.js'></script>
<script src="https://cdn.jsdelivr.net/npm/@fullcalendar/core@6.1.15/locales-all.global.min.js"></script>
<script>
    var enRutaEspecifica = true;
    document.addEventListener('DOMContentLoaded', function() {
        var multipleCancelButton = new Choices('#admin_user_ids', {
            removeItemButton: true, // Permite a los usuarios eliminar una selección
            searchEnabled: true,  // Habilita la búsqueda dentro del selector
            paste: false          // Deshabilita la capacidad de pegar texto en el campo
        });
    });
</script>
<script>
        $('#todoboton').click(function(e){
            e.preventDefault(); // Esto previene que el enlace navegue a otra página.
            $('#todoform').submit(); // Esto envía el formulario.
        });

        var events = @json($events);
        document.addEventListener('DOMContentLoaded', function() {

            var calendarEl = document.getElementById('calendar');
            var tooltip = document.getElementById('tooltip');
            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'listWeek',
                locale: 'es',
                navLinks: true,
                nowIndicator: true,
                businessHours: [
                    { daysOfWeek: [1], startTime: '08:00', endTime: '15:00' },
                    { daysOfWeek: [2], startTime: '08:00', endTime: '15:00' },
                    { daysOfWeek: [3], startTime: '08:00', endTime: '15:00' },
                    { daysOfWeek: [4], startTime: '08:00', endTime: '15:00' },
                    { daysOfWeek: [5], startTime: '08:00', endTime: '15:00' }
                ],
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridDay,listWeek'
                },
                events: events,
                eventClick: function(info) {
                    var event = info.event;
                    var clientId = event.extendedProps.client_id;
                    var budgetId = event.extendedProps.budget_id;
                    var projectId = event.extendedProps.project_id;
                    var clienteName = event.extendedProps.cliente_name || '';
                    var presupuestoRef = event.extendedProps.presupuesto_ref || '';
                    var presupuestoConp = event.extendedProps.presupuesto_conp || '';
                    var proyectoName = event.extendedProps.proyecto_name || '';
                    var descripcion = event.extendedProps.descripcion || '';

                    // Construye las rutas solo si los IDs existen
                    var ruta = clientId ? `{{ route("clientes.show", ":id") }}`.replace(':id', clientId) : '#';
                    var ruta2 = budgetId ? `{{ route("presupuesto.edit", ":id1") }}`.replace(':id1', budgetId) : '#';
                    var ruta3 = projectId ? `{{ route("campania.show", ":id2") }}`.replace(':id2', projectId) : '#';

                    // Construye el contenido del tooltip condicionalmente
                    var tooltipContent = '<div style="text-align: left;">' +
                        '<h5>' + event.title + '</h5>';

                    if (clienteName) {
                        tooltipContent += '<a href="' + ruta + '"><p><strong>Cliente:</strong> ' + clienteName + '</p></a>';
                    }

                    if (presupuestoRef || presupuestoConp) {
                        tooltipContent += '<a href="' + ruta2 + '"><p><strong>Presupuesto:</strong> ' +
                            (presupuestoRef ? 'Ref:' + presupuestoRef + '<br>' : '') +
                            (presupuestoConp ? 'Concepto: ' + presupuestoConp : '') +
                            '</p></a>';
                    }

                    if (proyectoName) {
                        tooltipContent += '<a href="' + ruta3 + '"><p><strong>Campaña:</strong> ' + proyectoName + '</p></a>';
                    }

                    if (descripcion) {
                        tooltipContent += '<p>' + descripcion + '</p>';
                    }

                    tooltipContent += '</div>';

                    var tooltip = new bootstrap.Tooltip(info.el, {
                        title: tooltipContent,
                        placement: 'top',
                        trigger: 'manual',
                        html: true,
                        container: 'body',
                        customClass: 'custom-tooltip', // Aplica una clase personalizada para el estilo
                        sanitize: false // Asegúrate de que el contenido HTML se procesa correctamente
                    });

                    // Cambia el color de fondo del tooltip
                    tooltip.show();
                    var tooltipElement = document.querySelector('.tooltip-inner');
                    if (tooltipElement) {
                        tooltipElement.style.backgroundColor = event.extendedProps.color || '#000'; // Usa el color del evento o negro por defecto
                    }

                    function handleClickOutside(event) {
                    if (!info.el.contains(event.target)) {
                        tooltip.dispose();
                        document.removeEventListener('click', handleClickOutside);
                    }
                }
                document.addEventListener('click', handleClickOutside);
            },
        });
            calendar.render();
        });

</script>
<script>
    function showTodoModal() {
        var todoModal = new bootstrap.Modal(document.getElementById('todoModal'));
        todoModal.show();
    }
    function showLlamadaModal() {
        var llamadaModal = new bootstrap.Modal(document.getElementById('llamadaModal'));
        llamadaModal.show();
    }
    document.addEventListener('DOMContentLoaded', function() {
        const progressCircles = document.querySelectorAll('.progress-circle');

        progressCircles.forEach(circle => {
            const percentage = circle.getAttribute('data-percentage');
            circle.style.setProperty('--percentage', percentage);

            let progressColor;

            if (percentage < 50) {
                progressColor = '#ff0000'; // Rojo
            } else if (percentage < 75) {
                progressColor = '#ffa500'; // Naranja
            } else {
                progressColor = '#4caf50'; // Verde
            }

            circle.style.setProperty('--progress-color', progressColor);
        });
    });
</script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.clickable').forEach(function(element) {
            element.addEventListener('click', function(event) {
                event.stopPropagation();


                var info = this.nextElementSibling;
                var isVisible = info.style.display === 'block';

                if (!isVisible) {
                    document.querySelectorAll('.info').forEach(function(infoElement) {
                        infoElement.style.display = 'none';
                    });
                    info.style.display = 'block';
                    markMessagesAsRead(this.getAttribute('data-todo-id'));
                } else {
                    info.style.display = 'none';
                }
            });
        });

        // Función para marcar mensajes como leídos
        function markMessagesAsRead(todoId) {
            if (!todoId) return;

            fetch(`mark-as-read/${todoId}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    let unreadCounter = document.querySelector(`[data-todo-id="${todoId}"] .pulse`);
                    if (unreadCounter) {
                        unreadCounter.textContent = '';
                        unreadCounter.style.display = 'none';
                    }
                }
            })
            .catch(error => console.error('Error al marcar mensajes como leídos:', error));
        }


        // Manejo de archivos
        document.querySelectorAll('#file-input').forEach(function(inputElement) {
            inputElement.addEventListener('change', function() {
                console.log('File input changed'); // Verifica que el evento se activa
                const fileIcon = this.closest('.input-group-text').querySelector('#file-icon');
                const fileClip = this.closest('.input-group-text').querySelector('#file-clip');

                if (this.files.length > 0) {
                    fileIcon.style.display = 'inline-block';
                    fileClip.style.display = 'none';
                } else {
                    fileIcon.style.display = 'none';
                    fileClip.style.display = 'inline-block';
                }
            });
        });
    });


    // Completar tarea
    function completeTask(event, todoId) {
        event.stopPropagation();
        const Toast = Swal.mixin({
            toast: true,
            position: "top-end",
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.onmouseenter = Swal.stopTimer;
                toast.onmouseleave = Swal.resumeTimer;
            },
        });

        fetch(`/todos/complete/${todoId}`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Content-Type': 'application/json'
            }
        }).then(response => response.json())
        .then(data => {
            if (data.success) {
                const card = document.getElementById(`todo-card-body-${todoId}`);
                if (card) {
                    card.style.backgroundColor = '#CDFEA4'; // Color verde claro
                }

                const completeButton = document.getElementById(`complete-button-${todoId}`);
                if (completeButton) {
                    completeButton.style.display = 'none';
                }
                Toast.fire({
                    icon: "success",
                    title: "Tarea completada con éxito!"
                });
            } else {
                Toast.fire({
                    icon: "error",
                    title: "Error al completar la tarea!"
                });
            }
        }).catch(error => console.error('Error:', error));
    }

    // Finalizar tarea
    function finishTask(event, todoId) {
        event.stopPropagation();
        const Toast = Swal.mixin({
            toast: true,
            position: "top-end",
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.onmouseenter = Swal.stopTimer;
                toast.onmouseleave = Swal.resumeTimer;
            },
        });

        fetch(`/todos/finish/${todoId}`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Content-Type': 'application/json'
            }
        }).then(response => response.json())
        .then(data => {
            if (data.success) {
                const card = document.getElementById(`todo-card-${todoId}`);
                if (card) {
                    card.style.display = 'none';
                }
                Toast.fire({
                    icon: "success",
                    title: "Tarea finalizada con éxito!"
                });
            } else {
                Toast.fire({
                    icon: "error",
                    title: "Error al finalizar la tarea!"
                });
            }
        }).catch(error => console.error('Error:', error));
    }

    // Enviar mensaje
    document.querySelectorAll('#enviar').forEach(function(button) {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            this.closest('form').submit();
        });
    });

    function updateUnreadMessagesCount(todoId) {
        fetch(`/todos/unread-messages-count/${todoId}`,{
            method: 'POST', // Cambiamos a POST
            headers: {
                'Content-Type': 'application/json', // Indicamos que enviamos JSON
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            },
            body: JSON.stringify({}) // Enviamos un cuerpo vacío o puedes agregar datos si es necesario

            })
            .then(response => response.json())
            .then(data => {
                const pulseDiv = document.querySelector(`#todo-card-${todoId} .pulse`);

                if (data.unreadCount > 0) {
                    pulseDiv.style.display = 'flex';
                    pulseDiv.textContent = data.unreadCount;
                } else {
                    pulseDiv.style.display = 'none';
                    pulseDiv.textContent = '';
                }
            });
    }

    function loadMessages(todoId) {
        $.ajax({
            url: `/todos/getMessages/${todoId}`,
            type: 'POST',
            contentType: 'application/json', // Especifica el tipo de contenido
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            },
            data: JSON.stringify({}),
            success: function(data) {
                let messagesContainer = $(`#todo-card-${todoId} .chat-container`);
                messagesContainer.html(''); // Limpiamos el contenedor
                data.forEach(function(message) {
                    let fileIcon = '';
                    if (message.archivo) {
                        fileIcon = `
                            <div class="file-icon">
                                <a href="/storage/${message.archivo}" target="_blank">
                                    <i class="fa-regular fa-file-lines fa-2x"></i>
                                </a>
                            </div>
                        `;
                    }
                    const messageClass = message.admin_user_id == {{ auth()->id() }} ? 'mine' : 'theirs';

                    messagesContainer.append(`
                        <div class="p-3 message ${messageClass}">
                            ${fileIcon}
                            <strong>${message.user.name}:</strong> ${message.mensaje}
                        </div>
                    `);
                });
            }
        });
    }

    function startPolling() {
        @if (count($to_dos) > 0)
            @foreach ($to_dos as $to_do)
                setInterval(function() {
                    updateUnreadMessagesCount('{{ $to_do->id }}');
                    loadMessages('{{ $to_do->id }}');
                }, 5000);  // Polling cada 5 segundos para cada to-do
            @endforeach
        @else
            console.log('No hay to-dos activos.');
        @endif
    }

    $(document).ready(function() {
        startPolling();
    });

    function showTodoModal() {
        var todoModal = new bootstrap.Modal(document.getElementById('todoModal'));
        todoModal.show();
    }
    document.addEventListener('DOMContentLoaded', function() {
        const taskSelect = document.getElementById('task_id');
        const clientSelect = document.getElementById('client_id');
        const budgetSelect = document.getElementById('budget_id');
        const projectSelect = document.getElementById('project_id');

        function disableOtherFields(selectedField) {
            const fields = [taskSelect, clientSelect, budgetSelect, projectSelect];
            fields.forEach(field => {
                if (field !== selectedField) {
                    field.disabled = true;
                    field.value = ''; // Limpiar selección en otros campos
                }
            });
        }

        function enableAllFields() {
            [taskSelect, clientSelect, budgetSelect, projectSelect].forEach(field => {
                field.disabled = false;
            });
        }

        // Añadir eventos a cada campo
        [taskSelect, clientSelect, budgetSelect, projectSelect].forEach(field => {
            field.addEventListener('change', function() {
                if (this.value) {
                    disableOtherFields(this);
                } else {
                    enableAllFields(); // Si no se selecciona nada, habilitar todos los campos
                }
            });
        });
    });
</script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/es.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        flatpickr("#dateRange", {
            mode: "range",
            dateFormat: "Y-m-d",
            locale: "es",
        });
    });
</script>
<script>
    $(document).ready(function () {
        // Escucha el evento change en el input con la clase 'produccion'
        $('.produccion').on('change', function (e) {
            console.log(e);
            // Obtén el valor del input que cambió
            let dateRange = $(this).val();

            if(dateRange.includes('a')) {
                fetchProductionData(dateRange);
            }
            // Muestra el valor en la consola (solo para verificar que se obtuvo bien)
            // Llama a la función para recargar los datos con fetch
            //fetchProductionData(dateRange);
        });

        // Función que hace el fetch para recargar los datos
        function fetchProductionData(dateRange) {
            fetch('/get-produccion', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') // Asegúrate de tener el token CSRF
                },
                body: JSON.stringify({ dateRange: dateRange })
            })
                .then(response => response.json())
                .then(data => {
                    console.log("Datos recibidos:", data);
                    // Aquí puedes actualizar la tabla con los datos recibidos
                    // Ejemplo de actualización de tabla
                    updateTableProduccion(data);
                })
                .catch(error => console.error('Error al recargar los datos:', error));
        }

        // Función para actualizar la tabla con los datos recibidos
        function updateTableProduccion(data) {
            let tbody = $('.producc tbody');
            tbody.empty(); // Limpia el contenido actual de la tabla

            if (data.length === 0) {
                tbody.append('<tr><td colspan="5">No hay datos disponibles</td></tr>');
            } else {
                data.forEach(item => {
                    let row = `
                        <tr>
                            <td>${item.nombre}</td>
                            <td>${item.inpuntualidad}</td>
                            <td>${item.horas_oficinas}</td>
                            <td>${item.horas_producidas ?? ''}</td>
                            <td>${item.productividad ?? ''}%</td>
                        </tr>
                    `;
                    tbody.append(row);
                });
            }
        }
    });
</script>
<script>
    $(document).ready(function () {
        // Escucha el evento change en el input con la clase 'produccion'
        $('.gestion').on('change', function (e) {
            // Obtén el valor del input que cambió
            let dateRange = $(this).val();

            if(dateRange.includes('a')) {
                fetchGestionData(dateRange);
            }

        });

        // Función que hace el fetch para recargar los datos
        function fetchGestionData(dateRange) {
            fetch('/get-gestion', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') // Asegúrate de tener el token CSRF
                },
                body: JSON.stringify({ dateRange: dateRange })
            })
                .then(response => response.json())
                .then(data => {
                    console.log("Datos recibidos:", data);
                    // Aquí puedes actualizar la tabla con los datos recibidos
                    // Ejemplo de actualización de tabla
                    updateTablegestion(data);
                })
                .catch(error => console.error('Error al recargar los datos:', error));
        }

        // Función para actualizar la tabla con los datos recibidos
        function updateTablegestion(data) {
            let tbody = $('.gest tbody');
            tbody.empty(); // Limpia el contenido actual de la tabla

            if (data.length === 0) {
                tbody.append('<tr><td colspan="5">No hay datos disponibles</td></tr>');
            } else {
                data.forEach(item => {
                    let row = `
                        <tr>
                            <td>${item.nombre}</td>
                            <td>${item.inpuntualidad}</td>
                            <td>${item.horas_oficinas}</td>
                            <td>${item.presu_generados ?? ''}</td>
                            <td>${item.llamadas ?? ''}</td>
                            <td>${item.kits ?? ''}</td>
                            <td>${item.peticiones ?? ''}</td>
                        </tr>
                    `;
                    tbody.append(row);
                });
            }
        }
    });
</script>
<script>
    $(document).ready(function () {
        // Escucha el evento change en el input con la clase 'produccion'
        $('.comercial').on('change', function (e) {
            console.log(e);
            // Obtén el valor del input que cambió
            let dateRange = $(this).val();

            if(dateRange.includes('a')) {
                fetchComencialData(dateRange);
            }
            // Muestra el valor en la consola (solo para verificar que se obtuvo bien)
            // Llama a la función para recargar los datos con fetch
            //fetchProductionData(dateRange);
        });

        // Función que hace el fetch para recargar los datos
        function fetchComencialData(dateRange) {
            fetch('/get-comercial', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') // Asegúrate de tener el token CSRF
                },
                body: JSON.stringify({ dateRange: dateRange })
            })
                .then(response => response.json())
                .then(data => {
                    console.log("Datos recibidos:", data);
                    // Aquí puedes actualizar la tabla con los datos recibidos
                    // Ejemplo de actualización de tabla
                    updateTableComercial(data);
                })
                .catch(error => console.error('Error al recargar los datos:', error));
        }

        // Función para actualizar la tabla con los datos recibidos
        function updateTableComercial(data) {
            let tbody = $('.comerc tbody');
            tbody.empty(); // Limpia el contenido actual de la tabla

            if (data.length === 0) {
                tbody.append('<tr><td colspan="5">No hay datos disponibles</td></tr>');
            } else {
                data.forEach(item => {
                    let row = `
                        <tr>
                            <td>${item.nombre}</td>
                            <td>${item.horas_oficinas}</td>
                            <td>${item.kits_creados}</td>
                            <td>${item.peticiones ?? ''}</td>
                        </tr>
                    `;
                    tbody.append(row);
                });
            }
        }
    });
</script>
<script>
    $(document).ready(function () {
        $('.contable').on('change', function (e) {

            let dateRange = $(this).val();

            if(dateRange.includes('a')) {
                fetchContabilidadData(dateRange);
            }

        });

        function fetchContabilidadData(dateRange) {
            fetch('get-contabilidad', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') // Asegúrate de tener el token CSRF
                },
                body: JSON.stringify({ dateRange: dateRange })
            })
                .then(response => response.json())
                .then(data => {
                    console.log("Datos recibidos:", data);
                    updateTableContabilidad(data);
                })
                .catch(error => console.error('Error al recargar los datos:', error));
        }

        function updateTableContabilidad(data) {
            let tbody = $('.contab tbody');
            tbody.empty(); // Limpia el contenido actual de la tabla

            if (data.length === 0) {
                tbody.append('<tr><td colspan="5">No hay datos disponibles</td></tr>');
            } else {
                data.forEach(item => {
                    let row = `
                        <tr>
                            <td>${item.nombre}</td>
                            <td>${item.inpuntualidad}</td>
                            <td>${item.horas_oficinas}</td>
                            <td>${item.facturas ?? ''}</td>
                            <td>${item.llamadas ?? ''}</td>
                        </tr>
                    `;
                    tbody.append(row);
                });
            }
        }
    });
</script>
@endsection

