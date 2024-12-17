@extends('layouts.app')

@section('titulo', 'Calendario de Citas')

@section('css')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.0/main.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.3/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
<meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('content')
<div class="page-heading card" style="box-shadow: none !important">

    {{-- Titulos --}}
    <div class="page-title card-body p-3">
        <div class="row justify-content-between">
            <div class="col-12 col-md-4 order-md-1 order-first">
                <h3><i class="bi bi-calendar"></i> Calendario de Citas</h3>
                <p class="text-subtitle text-muted">Visualiza y gestiona tus citas</p>
            </div>

            <div class="col-12 col-md-4 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Calendario de Citas</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <section class="section pt-4">
        <div class="card">
            <div class="card-body">
                <div id="calendar"></div>
            </div>
        </div>
    </section>

    <!-- Modal para crear/editar citas -->
    <div class="modal fade" id="appointmentModal" tabindex="-1" aria-labelledby="appointmentModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="appointmentForm">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="appointmentModalLabel">Crear/Editar Cita</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="client_search" class="form-label">Buscar Cliente</label>
                            <input type="text" id="client_search" class="form-control" placeholder="Escriba el nombre del cliente">
                            <ul id="client_list" class="list-group mt-2" style="display: none;"></ul>
                            <input type="hidden" name="client_id" id="client_id">
                        </div>
                        <div class="mb-3">
                            <label for="appointment_date" class="form-label">Fecha de la Cita</label>
                            <input type="date" name="appointment_date" id="appointment_date" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="appointment_time" class="form-label">Hora de la Cita</label>
                            <input type="time" name="appointment_time" id="appointment_time" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="vehicle_details" class="form-label">Detalles del Vehículo</label>
                            <input type="text" name="vehicle_details" id="vehicle_details" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="notes" class="form-label">Notas</label>
                            <textarea name="notes" id="notes" class="form-control"></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="phone" class="form-label">Teléfono</label>
                            <input type="text" name="phone" id="phone" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label for="estado" class="form-label">Estado</label>
                            <select name="estado" id="estado" class="form-control">
                                <option value="Pendiente">Pendiente</option>
                                <option value="Completada">Completada</option>
                                <option value="Rechazada">Rechazada</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                        <button type="button" id="deleteAppointment" class="btn btn-danger" style="display: none;">Eliminar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>
@endsection

@section('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.3/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.0/main.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.0/locales/es.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $(document).ready(function() {
        // Configurar el token CSRF para todas las solicitudes AJAX
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        var calendarEl = document.getElementById('calendar');

        var calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            locale: 'es',
            events: function(fetchInfo, successCallback, failureCallback) {
                $.ajax({
                    url: '{{ route('appointments.get') }}',
                    method: 'GET',
                    success: function(data) {
                        var events = data.map(function(event) {
                            var color;
                            switch (event.extendedProps.estado) {
                                case 'Pendiente':
                                    color = 'yellow';
                                    break;
                                case 'Completada':
                                    color = 'green';
                                    break;
                                case 'Rechazada':
                                    color = 'red';
                                    break;
                                default:
                                    color = 'blue'; // Color por defecto
                            }
                            return {
                                id: event.id,
                                title: event.title,
                                start: event.start,
                                color: color,
                                extendedProps: event.extendedProps
                            };
                        });
                        successCallback(events);
                    },
                    error: function() {
                        failureCallback();
                    }
                });
            },
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,timeGridWeek,timeGridDay'
            },
            eventTimeFormat: { // Configurar el formato de la hora
                hour: '2-digit',
                minute: '2-digit',
                hour12: false
            },
            dateClick: function(info) {
                // Abrir el modal para crear una nueva cita
                $('#appointmentModal').modal('show');
                $('#appointmentForm').trigger("reset");
                $('#appointment_date').val(info.dateStr);
                $('#appointmentModalLabel').text('Crear Cita');
                $('#appointmentForm').attr('action', '{{ route('appointments.store') }}');
                $('#appointmentForm').attr('method', 'POST');
                $('#deleteAppointment').hide();
            },
            eventClick: function(info) {
                // Abrir el modal para editar la cita
                $('#appointmentModal').modal('show');
                $('#appointmentModalLabel').text('Editar Cita');
                $('#appointmentForm').attr('action', '/appointments/' + info.event.id);
                $('#appointmentForm').attr('method', 'PUT');
                $('#deleteAppointment').show().data('id', info.event.id);

                // Cargar datos de la cita en el formulario
                $('#client_search').val(info.event.extendedProps.name);
                $('#client_id').val(info.event.extendedProps.client_id);
                $('#appointment_date').val(info.event.startStr.split('T')[0]);
                $('#appointment_time').val(info.event.startStr.split('T')[1].substring(0, 5));
                $('#vehicle_details').val(info.event.extendedProps.vehicle_details);
                $('#notes').val(info.event.extendedProps.notes);
                $('#phone').val(info.event.extendedProps.phone);
                $('#estado').val(info.event.extendedProps.estado);
            }
        });

        calendar.render();

        // Búsqueda de clientes
        $('#client_search').on('input', function() {
            var query = $(this).val().toLowerCase();
            var clientList = $('#client_list');
            clientList.empty().hide();

            if (query.length > 0) {
                @foreach($clients as $client)
                    var clientName = "{{ $client->name }}".toLowerCase();
                    if (clientName.includes(query)) {
                        clientList.append('<li class="list-group-item" data-id="{{ $client->id }}" data-phone="{{ $client->phone }}">{{ $client->name }}</li>');
                    }
                @endforeach
                clientList.show();
            }
        });

        // Seleccionar cliente de la lista
        $('#client_list').on('click', 'li', function() {
            var selectedClient = $(this).text();
            var clientId = $(this).data('id');
            var clientPhone = $(this).data('phone');
            $('#client_search').val(selectedClient);
            $('#client_id').val(clientId);
            $('#phone').val(clientPhone);
            $('#client_list').hide();
        });

        // Manejar el envío del formulario de citas
        $('#appointmentForm').on('submit', function(e) {
            e.preventDefault();
            var formData = $(this).serializeArray();
            var clientName = $('#client_search').val();

            // Si no se seleccionó un cliente, usar el nombre ingresado
            if (!$('#client_id').val()) {
                formData.push({ name: 'name', value: clientName });
            } else {
                formData.push({ name: 'name', value: $('#client_search').val() });
            }

            var actionUrl = $(this).attr('action');
            var method = $(this).attr('method');

            $.ajax({
                url: actionUrl,
                method: method,
                data: formData,
                success: function(response) {
                    $('#appointmentModal').modal('hide');
                    calendar.refetchEvents(); // Recargar eventos en el calendario
                    Swal.fire({
                        icon: 'success',
                        title: 'Éxito',
                        text: 'Cita guardada con éxito.',
                        timer: 2000,
                        showConfirmButton: false
                    });
                },
                error: function(response) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Error al guardar la cita.',
                        timer: 2000,
                        showConfirmButton: false
                    });
                }
            });
        });

        // Manejar la eliminación de citas
        $('#deleteAppointment').on('click', function() {
            var appointmentId = $(this).data('id');
            Swal.fire({
                title: '¿Estás seguro?',
                text: "¡No podrás revertir esto!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sí, eliminarlo!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '/appointments/' + appointmentId,
                        method: 'DELETE',
                        success: function(response) {
                            $('#appointmentModal').modal('hide');
                            calendar.refetchEvents(); // Recargar eventos en el calendario
                            Swal.fire(
                                'Eliminado!',
                                'La cita ha sido eliminada.',
                                'success'
                            );
                        },
                        error: function(response) {
                            Swal.fire(
                                'Error!',
                                'Error al eliminar la cita.',
                                'error'
                            );
                        }
                    });
                }
            });
        });
    });
</script>
@include('partials.toast')
@endsection