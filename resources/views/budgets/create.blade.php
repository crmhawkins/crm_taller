@extends('layouts.app')

@section('titulo', 'Crear Presupuesto')

@section('css')
{{-- <link rel="stylesheet" href="{{asset('assets/vendors/choices.js/choices.min.css')}}" /> --}}
<link rel="stylesheet" href="assets/vendors/simple-datatables/style.css">
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
<style>
    .text-danger {
        color: red;
    }
    .label-danger {
        color: red;
    }
    .modal-backdrop.show{
        display: none !important;
    }
</style>

@endsection

@section('content')
    <div class="page-heading card" style="box-shadow: none !important" >
        <div class="page-title card-body">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>Crear Presupuesto</h3>
                    <p class="text-subtitle text-muted">Formulario para registrar un presupuesto</p>
                </div>

                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{route('presupuestos.index')}}">Presupuestos</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Crear presupuesto</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>

        <section class="section mt-4">
            <div class="card">
                <div class="card-body">
                    <form id="budgetForm" action="{{route('presupuesto.store')}}" method="POST">
                        @csrf
                        @if (isset($petitionId))
                        <input type="text" name="petitionId" value="{{$petitionId}}" hidden>
                        @endif
                        <div class="bloque-formulario">
                            <div class="row">
                                <div class="col-sm-12 col-md-6">
                                    {{-- Cliente model:Client --}}
                                    <div class="form-group">
                                        <label class="mb-2 text-left">Cliente Asociado</label>
                                        <div class="flex flex-row align-items-start mb-0">
                                            <select id="cliente" class="select2 w-100 form-select @error('client_id') is-invalid @enderror" name="client_id" >
                                                @if ($clientes->count() > 0)
                                                <option value="">Seleccione un Cliente</option>
                                                    @foreach ($clientes as $cliente)
                                                        <option @if(old('client_id', request('cliente_id')) == $cliente->id) selected @endif value="{{ $cliente->id }}">{{ $cliente->company ?? $cliente->name }}</option>
                                                    @endforeach
                                                @else
                                                    <option value="">No existen clientes todavia</option>
                                                @endif
                                            </select>
                                            <button id="newClient" type="button" class="btn btn-color-1 ml-3" style="height: fit-content" data-bs-toggle="modal" data-bs-target="#createClientModal" @if(isset($petitionId)){{'disabled'}}@endif><i class="fa-solid fa-plus"></i></button>
                                        </div>
                                        @error('client_id')
                                            <p class="invalid-feedback d-block" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </p>
                                        @enderror
                                    </div>
                                </div>
                                {{-- <div class="col-sm-12 col-md-6">
                                    <div class="form-group">
                                        <label class="mb-2 text-left">Campañas</label>
                                        <div class="flex flex-row align-items-start mb-0">

                                            <select class="form-select w-100 @error('project_id') is-invalid @enderror" name="project_id"  id="proyecto" @if($campanias != null )@if( $campanias->count() < 0){{'disabled'}} @endif @endif >
                                                @if ($campanias != null)
                                                    @if ($campanias->count() > 0)
                                                        <option value="">Seleccione una Campaña</option>
                                                        @foreach ( $campanias as $campania )
                                                            <option @if(old('project_id', $projectId) == $campania->id) {{'selected'}} @endif value="{{$campania->id}}">{{$campania->name}}</option>
                                                        @endforeach
                                                    @else
                                                        <option value="">No existen campañas todavia</option>
                                                    @endif
                                                @else
                                                    <option value="">No existen campañas todavia</option>
                                                @endif

                                            </select>
                                            <button id="newCampania" type="button" class="btn btn-color-1 ml-3" style="height: fit-content"><i class="fa-solid fa-plus"></i></button>
                                        </div>
                                        @error('project_id')
                                            <p class="invalid-feedback d-block" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </p>
                                        @enderror
                                    </div>
                                </div> --}}
                                {{-- <div class="col-sm-12 col-md-6">
                                    <div class="form-group mb-3">
                                        <label class="mb-2 text-left">Gestor</label>
                                        <select class="choices form-select w-100 @error('admin_user_id') is-invalid @enderror" name="admin_user_id" id="gestor">
                                            @if ($gestores->count() > 0)
                                                <option value="">Seleccione gestor</option>
                                                @foreach ( $gestores as $gestor )
                                                    <option {{old('admin_user_id') != null ? (old('admin_user_id') == $gestor->id ? 'selected' : '' ) : ($gestorId != null ? ($gestorId == $gestor->id ? 'selected' : '') : ( Auth::user()->id == $gestor->id ? 'selected' : '')) }}  value="{{$gestor->id}}">{{$gestor->name}}</option>
                                                @endforeach
                                            @else
                                                <option value="{{null}}">No existen gestores todavia</option>
                                            @endif
                                        </select>
                                        @error('admin_user_id')
                                            <p class="invalid-feedback d-block" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </p>
                                        @enderror
                                    </div>
                                </div> --}}
                                <input type="hidden" name="admin_user_id" value="{{ Auth::user()->id }}">
                                {{-- <div class="col-sm-12 col-md-6">
                                    <div class="form-group mb-3">
                                        <label class="mb-2 text-left">Comercial</label>
                                        <select class="choices form-select w-75" name="commercial_id">
                                            @if ($comerciales->count() > 0)
                                            <option value="">S.Comercial</option>
                                                @foreach ( $comerciales as $comercial )
                                                    <option {{old('commercial_id') == $comercial->id ? 'selected' : '' }} value="{{$comercial->id}}">{{$comercial->name}}</option>
                                                @endforeach
                                            @else
                                                <option value="{{null}}">No existen comerciales todavia</option>
                                            @endif
                                        </select>
                                    </div>
                                </div> --}}
                            </div>
                            <div class="row">
                                <div class="col-sm-12 col-md-6">
                                    {{-- Formas de Pago model:PaymentMethod --}}
                                    <div class="form-group mb-3">
                                        <label class="mb-2 text-left">Forma de Pago</label>
                                        <select class="choices form-select w-75" name="payment_method_id">
                                            @if ($formasPago->count() > 0)
                                                @foreach ( $formasPago as $formaPago )
                                                    <option @if ( $formaPago->id === 1 ) {{'selected'}} @endif value="{{$formaPago->id}}">{{$formaPago->name}}</option>
                                                @endforeach
                                            @else
                                                <option value="{{null}}">No existen formas de pago todavia</option>
                                            @endif
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-6">
                                    {{-- Concepto --}}
                                    <div class="form-group mb-3">
                                        <label class="mb-2 text-left" for="concept">Titulo:</label>
                                        <input type="text" class="form-control @error('concept') is-invalid @enderror" id="concept" value="{{ old('concept') }}" name="concept">
                                        @error('concept')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12 col-md-6">
                                    {{-- Observaciones --}}
                                    <div class="form-group">
                                        <label for="description">Observaciones:</label>
                                        <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description">{{ old('description') }}</textarea>
                                        @error('description')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-6">
                                    {{-- Nota --}}
                                    <div class="form-group">
                                        <label for="note">Nota Interna:</label>
                                        <textarea class="form-control @error('note') is-invalid @enderror" id="note" name="note">{{ old('note') }}</textarea>
                                        @error('note')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <input type="hidden" name="coche_id" id="car_id"> <!-- Campo oculto para el car_id -->

                            {{-- Boton --}}
                            <div class="form-group mt-5">
                                <button type="submit" class="btn btn-success w-100 text-uppercase">
                                    {{ __('Registrar') }}
                                </button>
                            </div>

                        </div>

                    </form>
                </div>
            </div>
        </section>
    </div>

    <!-- Modal para crear cliente y coche -->
    <div class="modal fade" id="createClientModal" tabindex="-1" aria-labelledby="createClientModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createClientModalLabel">Crear Cliente</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Contenedor para el mensaje de error -->
                    <div id="errorMessage" class="text-danger mb-3" style="display: none;"></div>

                    <!-- Contenedor para los botones de redirección -->
                    <div id="redirectButtons" class="mb-3" style="display: none;"></div>

                    <!-- Paso 1: Datos del Cliente -->
                    <div id="step1">
                        <div class="row">
                            <div class="col-md-4 mt-2">
                                <div class="form-group">
                                    <label for="cif">DNI/CIF</label>
                                    <input type="text" class="form-control" id="cif" name="cif" required>
                                </div>
                            </div>
                            <div class="col-md-4 mt-2">
                                <div class="form-group">
                                    <label for="name">Nombre</label>
                                    <input type="text" class="form-control" id="name" name="name" required>
                                </div>
                            </div>
                            <div class="col-md-4 mt-2">
                                <div class="form-group">
                                    <label for="primerApellido">Primer Apellido</label>
                                    <input type="text" class="form-control" id="primerApellido" name="primerApellido">
                                </div>
                            </div>
                            <div class="col-md-4 mt-2">
                                <div class="form-group">
                                    <label for="segundoApellido">Segundo Apellido</label>
                                    <input type="text" class="form-control" id="segundoApellido" name="segundoApellido">
                                </div>
                            </div>
                            <div class="col-md-4 mt-2">
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input type="email" class="form-control" id="email" name="email">
                                </div>
                               
                            </div>
                            
                            
                            <div class="col-md-4 mt-2">
                                <div class="form-group">
                                    <label for="telefono">Teléfono</label>
                                    <input type="text" class="form-control" id="telefono" name="telefono">
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Paso 2: Datos del Coche -->
                    <div id="step2" style="display: none;">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="matricula">Matrícula</label>
                                    <input type="text" class="form-control" id="matricula" name="matricula">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="marca">Marca</label>
                                    <input type="text" class="form-control" id="marca" name="marca">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="modelo">Modelo</label>
                                    <input type="text" class="form-control" id="modelo" name="modelo">
                                </div>
                            </div>
                            
                            
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="anio">Año</label>
                                    <input type="number" class="form-control" id="anio" name="anio">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-primary" id="nextStep">Siguiente</button>
                    <button type="button" class="btn btn-success" id="saveClient" style="display: none;">Guardar</button>
                </div>
            </div>
        </div>
    </div>

    <div id="clientExistsAlert" class="alert alert-warning" style="display: none;"></div>
    <div id="carExistsAlert" class="alert alert-warning" style="display: none;"></div>
@php
    $peticionexiste = isset($petitionId) ? @json($petitionId) : null;
@endphp
@endsection

@section('scripts')
{{-- <script src="{{asset('assets/vendors/choices.js/choices.min.js')}}"></script> --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
<script>
    $(document).ready(function() {
        $('.select2').select2();
    });
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.8.7/chosen.jquery.min.js" integrity="sha512-rMGGF4wg1R73ehtnxXBt5mbUfN9JUJwbk21KMlnLZDJh7BkPmeovBuddZCENJddHYYMkCh9hPFnPmS9sspki8g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script type="text/javascript">
    var urlTemplate = "{{ route('campania.createFromBudget', ['cliente' => 'CLIENTE_ID']) }}";
    var urlTemplatePetition = "{{ route('campania.createFromBudgetAndPetition', ['cliente' => 'CLIENTE_ID','petitionid' => 'PETITION_ID']) }}";
    var urlTemplateCliente = "{{ route('cliente.createFromBudget') }}";

</script>

<script>
    $(document).ready(function() {
        var currentStep = 1;

        // Inicializar Select2
        $('#cliente').select2({
            placeholder: "Seleccione un Cliente",
            allowClear: true
        });

        $('#nextStep').click(function() {
            if (currentStep === 1) {
                // Validar campos requeridos
                var name = $('#name').val().trim();
                var cif = $('#cif').val().trim();

                if (name === '' || cif === '') {
                    $('#errorMessage').text('Por favor, completa todos los campos requeridos.').show();

                    // Resaltar los labels de los campos requeridos
                    if (name === '') {
                        $('label[for="name"]').addClass('label-danger');
                    } else {
                        $('label[for="name"]').removeClass('label-danger');
                    }

                    if (cif === '') {
                        $('label[for="cif"]').addClass('label-danger');
                    } else {
                        $('label[for="cif"]').removeClass('label-danger');
                    }

                    return;
                }

                $('#errorMessage').hide();
                $('label[for="name"]').removeClass('label-danger');
                $('label[for="cif"]').removeClass('label-danger');
                $('#step1').hide();
                $('#step2').show();
                $('#createClientModalLabel').text('Crear Coche');
                $('#nextStep').hide();
                $('#saveClient').show();
                currentStep++;
            }
        });

        $('#saveClient').click(function() {
            var name = $('#name').val().trim();
            var cif = $('#cif').val().trim();
            var primerApellido = $('#primerApellido').val().trim();
            var segundoApellido = $('#segundoApellido').val().trim();
            var email = $('#email').val().trim();
            var phone = $('#telefono').val().trim();
            var matricula = $('#matricula').val().trim();
            var modelo = $('#modelo').val().trim();
            var anio = $('#anio').val().trim();
            var marca = $('#marca').val().trim();

            $.ajax({
                url: '{{ route("store.client.car") }}',
                method: 'POST',
                data: {
                    name: name,
                    cif: cif,
                    matricula: matricula,
                    modelo: modelo,
                    anio: anio,
                    marca: marca,
                    primerApellido: primerApellido,
                    segundoApellido: segundoApellido,
                    email: email,
                    phone: phone,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    if (response.success) {
                        // Añadir la nueva opción al <select> y seleccionarla
                        var newOption = new Option(response.client.name, response.client.id, true, true);
                        window.currentClientId = response.client.id;
                        window.currentCarId = response.car.id;
                        $('#car_id').val(response.car.id);
                        $('#cliente').append(newOption).trigger('change');

                        $('#successMessage').text('Cliente y coche creados exitosamente.').show();
                        $('#createClientModal').modal('hide');
                    }else{
                        window.currentClientId = null;
                        window.currentCarId = null;
                    }
                }
            });
        });

        function cancelProcess() {
            $('#createClientModal').modal('hide');
        }

        $('#createClientModal').on('hidden.bs.modal', function () {
            $('#step1').show();
            $('#step2').hide();
            $('#createClientModalLabel').text('Crear Cliente');
            $('#nextStep').show();
            $('#saveClient').hide();
            $('#redirectButtons').hide().empty(); // Limpiar botones al cerrar el modal
            $('#errorMessage').hide(); // Ocultar mensaje de error al cerrar el modal
            $('label').removeClass('label-danger'); // Quitar clase de error de todos los labels
            currentStep = 1;

            // Limpiar los campos de entrada
            $('#name').val('');
            $('#primerApellido').val('');
            $('#segundoApellido').val('');
            $('#cif').val('');
            $('#email').val('');
            $('#telefono').val('');
            $('#matricula').val('');
            $('#marca').val('');
            $('#modelo').val('');
            $('#anio').val('');
        });

        // Check client by DNI
        $('#cif').on('change', function() {
            var cif = $(this).val();
            $.ajax({
                url: '{{ route("check.client") }}',
                method: 'POST',
                data: { cif: cif, _token: '{{ csrf_token() }}' },
                success: function(response) {
                    if (response.exists) {
                        window.currentClientId = response.client.id;
                        $('#name').val(response.client.name);
                        $('#email').val(response.client.email);
                        $('#telefono').val(response.client.telefono);
                        $('#redirectButtons').show().html(
                            '<button class="btn btn-warning mb-2" onclick="window.open(\'' + response.url + '\', \'_blank\')">Ver Cliente Existente</button>'
                        );
                    } else {
                        window.currentClientId = null;
                        $('#redirectButtons').hide().empty();
                    }
                }
            });
        });

        // Check car by matricula
        $('#matricula').on('change', function() {
            var matricula = $(this).val();
            $.ajax({
                url: '{{ route("check.car") }}',
                method: 'POST',
                data: { matricula: matricula, _token: '{{ csrf_token() }}' },
                success: function(response) {
                    if (response.exists) {
                        $('#marca').val(response.car.marca);
                        $('#modelo').val(response.car.modelo);
                        $('#anio').val(response.car.anio);
                        window.currentCarId = response.car.id;
                        var currentClientId = window.currentClientId;
                        if (response.car.cliente_id !== currentClientId) {
                            console.log('car cliente id: ' + response.car.cliente_id);
                            console.log('current client id: ' + currentClientId);
                            $('#errorMessage').text('El coche ya está asignado a otro cliente. Al guardar, se reasignará al nuevo cliente.').show();
                        } else {
                            $('#errorMessage').hide();
                        }
                        $('#redirectButtons').show().html(
                            '<button class="btn btn-warning mb-2" onclick="window.open(\'' + response.carUrl + '\', \'_blank\')">Ver Coche Existente</button>' +
                            '<button class="btn btn-warning mb-2" onclick="window.open(\'' + response.clientUrl + '\', \'_blank\')">Ver Cliente del Coche</button>'
                        );
                    } else {
                        $('#redirectButtons').hide().empty();
                    }
                }
            });
        });
    });
</script>
@endsection

