@extends('layouts.app')

@section('titulo', 'Editar Cliente')

@section('css')
<link rel="stylesheet" href="{{asset('assets/vendors/choices.js/choices.min.css')}}" />

@endsection

@section('content')

    <div class="page-heading card" style="box-shadow: none !important" >
        @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li><i class="fa-solid fa-circle-exclamation"></i> {{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
        {{-- Titulos --}}
        <div class="page-title card-body">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>Editar Cliente</h3>
                    <p class="text-subtitle text-muted">Formulario para editar a un cliente/leads.</p>
                </div>

                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{route('clientes.index')}}">Clientes</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Editar cliente</li>
                        </ol>
                    </nav>

                </div>
            </div>
        </div>

        <section class="section mt-4">
            <div class="card">
                <div class="card-body">
                    <form action="{{route('clientes.update', $cliente->id)}}" method="POST" class="form-primary">
                        @csrf
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group mt-2">
                                    <label for="name">Nombre:</label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" value="{{ old('name', $cliente->name) }}" name="name">
                                    @error('name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group mt-2">
                                    <label for="name">Primer apellido</label>
                                    <input placeholder="Primer apellido (obligatorio en caso de particulares)" type="text" class="form-control @error('primerApellido') is-invalid @enderror" id="primerApellido" value="{{ old('primerApellido',$cliente->primerApellido)}}" name="primerApellido">
                                    @error('primerApellido')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group mt-2">
                                    <label for="name">Segundo apellido</label>
                                    <input placeholder="Segundo apellido (obligatorio en caso de particulares)" type="text" class="form-control @error('segundoApellido') is-invalid @enderror" id="segundoApellido" value="{{ old('segundoApellido',$cliente->segundoApellido) }}" name="segundoApellido">
                                    @error('segundoApellido')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group mt-3 ">
                                    <label for="tipoCliente" class="form-label">Tipo de cliente</label>
                                    <div class="d-flex">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input @error('tipoCliente') is-invalid @enderror" type="radio" name="tipoCliente" id="empresa" value="0"
                                                   {{ old('tipoCliente',$cliente->tipoCliente) == '0' ? 'checked' : '' }}>
                                            <label class="form-check-label" for="empresa">Empresa</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input @error('tipoCliente') is-invalid @enderror" type="radio" name="tipoCliente" id="particular" value="1"
                                                   {{ old('tipoCliente',$cliente->tipoCliente) == '1' ? 'checked' : '' }}>
                                            <label class="form-check-label" for="particular">Particular</label>
                                        </div>
                                    </div>
                                    @error('tipoCliente')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-md-3">
                                <div class="form-group mt-2">
                                    <label for="cif">CIF/DNI:</label>
                                    <input type="text" class="form-control @error('cif') is-invalid @enderror" id="cif" value="{{ old('cif', $cliente->cif) }}" name="cif">
                                    @error('cif')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                    @enderror
                                </div>
                            </div>
                            {{-- <div class="col-md-3">
                                <div class="form-group mt-2">
                                    <label for="identifier">Marca:</label>
                                    <input type="text" class="form-control @error('identifier') is-invalid @enderror" id="identifier" value="{{ old('identifier', $cliente->identifier) }}" name="identifier">
                                    @error('identifier')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                    @enderror
                                </div>
                            </div> --}}
                            <div class="col-md-3">
                                <div class="form-group mt-2">
                                    <label for="birthdate">Fecha de alta:</label>
                                    <input type="date" class="form-control @error('birthdate') is-invalid @enderror" id="birthdate" value="{{ old('birthdate', $cliente->birthdate) }}" name="birthdate">
                                    @error('birthdate')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-md-3" style="display: none;">
                                <div class="form-group mt-2">
                                    <label for="admin_user_id">Gestor:</label>
                                    <select class="choices form-select @error('admin_user_id') is-invalid @enderror" id="admin_user_id" name="admin_user_id">
                                        <option value="">Seleccione el gestor del cliente</option>
                                        @foreach ($gestores as $gestor)
                                            <option value="{{ $gestor->id }}"
                                                {{ (old('admin_user_id') ?? $cliente->admin_user_id) == $gestor->id ? 'selected' : '' }}>
                                                {{ $gestor->name }} {{ $gestor->surname }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('admin_user_id')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mt-2">
                                    <label for="address">Dirección:</label>
                                    <input type="text" class="form-control @error('address') is-invalid @enderror" id="address" value="{{ old('address', $cliente->address) }}" name="address">
                                    @error('address')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group mt-2">
                                    <label for="zipcode">Código postal:</label>
                                    <input type="text" class="form-control @error('zipcode') is-invalid @enderror" id="zipcode" value="{{ old('zipcode', $cliente->zipcode) }}" name="zipcode">
                                    @error('zipcode')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group mt-2">
                                    <label for="city">Ciudad:</label>
                                    <input type="text" class="form-control @error('city') is-invalid @enderror" id="city" value="{{ old('city', $cliente->city) }}" name="city">
                                    @error('city')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                    @enderror
                                </div>
                            </div>
                            
                           
                            <div class="col-md-3">
                                <div class="form-group mt-2">
                                    <label for="province">Provincia:</label>
                                    <input type="text" class="form-control @error('province') is-invalid @enderror" id="province" value="{{ old('province', $cliente->province) }}" name="province">
                                    @error('province')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group mt-2">
                                    <label for="country">Pais:</label>
                                    <select class="choices form-select" name="country">
                                        @if ($countries->count() > 0)
                                            <option value="{{null}}">Seleccione un pais </option>
                                            @foreach ( $countries as $country )
                                                <option @if ($cliente->country == $country->name) {{'selected'}} @endif value="{{$country->name}}" >{{$country->name}}</option>
                                            @endforeach
                                        @else
                                            <option value="{{null}}">No existen clientes todavia</option>
                                        @endif
                                    </select>
                                    @error('country')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-md-3">
                                <div class="form-group mt-2">
                                    <label for="company">Nombre de la empresa:</label>
                                    <input type="text" class="form-control @error('company') is-invalid @enderror" id="company"value="{{ old('company', $cliente->company) }}" name="company">
                                    @error('company')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group mt-2">
                                    <label for="activity">Actividad:</label>
                                    <input type="text" class="form-control @error('activity') is-invalid @enderror" id="activity" value="{{ old('activity', $cliente->activity) }}" name="activity">
                                    @error('activity')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                    @enderror
                                </div>
                            </div>

                        </div>

                            <div class="form-group mt-3">
                                <div class="form-floating">
                                    <textarea class="form-control" placeholder="Escribe la anotación..."
                                        id="floatingTextarea" name="notes">{{ old('notes', $cliente->notes) }}</textarea>
                                    <label for="floatingTextarea">Notas</label>
                                </div>
                                @error('notes')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                @enderror
                            </div>
                        {{-- <div class="row mt-3">
                            <div class="form-group col-6">
                                <label for="Usuario">Usuario portal:</label>
                                <input type="text" disabled class="form-control @error('Usuario') is-invalid @enderror" id="Usuario" value="{{ 'HK#'.$cliente->id }}" >
                            </div>
                            <div class="form-group col-6">
                                <label for="pin">Pin portal:</label>
                                <input type="text" class="form-control @error('pin') is-invalid @enderror" id="pin" value="{{ old('pin', $cliente->pin) }}" name="pin">
                                @error('pin')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                @enderror
                            </div>
                        </div> --}}

                        <h3 class="mt-5 mb-2 text-center uppercase">Presupuestos</h3>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Referencia</th>
                                    <th>Fecha</th>
                                    <th>Concepto</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($presupuestos as $presupuesto)
                                    <tr>
                                        <td>{{ $presupuesto->reference }}</td>
                                        <td>{{  date('d/m/Y', strtotime($presupuesto->created_at)) }}</td>
                                        <td>{{ $presupuesto->concept }}</td>
                                        <td>
                                            <a href="{{ route('presupuesto.edit', $presupuesto->id) }}" class="btn btn-secondary">Editar</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="form-group mt-3">
                            <a href="{{ route('presupuesto.create', ['cliente_id' => $cliente->id]) }}" class="btn btn-primary">
                                <i class="fas fa-file-invoice-dollar"></i> Crear Presupuesto
                            </a>
                        </div>
                        
                        <h3 class="mt-5 mb-2 text-center uppercase">Coches</h3>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Marca</th>
                                    <th>Modelo</th>
                                    <th>Color</th>
                                    <th>Matricula</th>
                                    <th>Año</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($coches as $coche)
                                    <tr>
                                        <td>{{ $coche->marca }}</td>
                                        <td>{{ $coche->modelo }}</td>
                                        <td>{{ $coche->color }}</td>
                                        <td>{{ $coche->matricula }}</td>
                                        <td>{{ $coche->anio }}</td>
                                        <td>
                                            <a href="{{ route('coches.edit', $coche->id) }}" class="btn btn-primary">Ver</a>
                                            <button type="button" class="btn btn-danger remove-car" data-id="{{ $coche->id }}">Quitar</button>
                                            <a href="{{ route('hojas_inspeccion.index', $coche->id) }}" class="btn btn-secondary ">Hojas Inspección</a>
                                            @if($coche->siniestros->count() > 0)
                                                <a href="{{ route('siniestro.index', ['coche_id' => $coche->id]) }}" class="btn btn-info">Partes de Trabajo</a> <!-- Nuevo botón -->
                                            @endif
                                            <a href="{{ route('siniestro.create', ['coche_id' => $coche->id, 'cliente_id' => $cliente->id]) }}" class="btn btn-warning">Añadir Parte de Trabajo</a> <!-- Nuevo botón -->

                                            <a href="{{ route('visitas.index', ['coche_id' => $coche->id]) }}" class="btn btn-info">Visitas</a>

                                        </td>
                                    </tr>
                                @endforeach
                                <tr>
                                    <td colspan="6" class="text-center">
                                        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addCarModal">
                                            <i class="fas fa-plus"></i> Añadir Coche
                                        </button>
                                        <button type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#selectCarModal">
                                            <i class="fas fa-search"></i> Seleccionar Coche
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>

                        

                        <h3 class="mt-5 mb-2 text-center uppercase">Coches de sustitución asignados</h3>
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Coche de Sustitución</th>
                                        <th>Fecha de Inicio</th>
                                        <th>Fecha de Fin</th>
                                        <th>Estado</th>
                                        <th>Km Entregado</th>
                                        <th>Km Devuelto</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($reservasCoche as $reserva)
                                        <tr>
                                            <td>{{ $reserva->cocheSustitucion->marca }} {{ $reserva->cocheSustitucion->modelo }}</td>
                                            <td>{{ $reserva->fecha_inicio }}</td>
                                            <td>
                                                <input type="date" class="form-control fecha-fin" data-id="{{ $reserva->id }}" value="{{ $reserva->fecha_fin }}">
                                            </td>
                                            <td style="cursor: pointer;">
                                                <select class="form-select estado-reserva" data-id="{{ $reserva->id }}">
                                                    <option value="pendiente" {{ $reserva->estado == 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                                                    <option value="entregado" {{ $reserva->estado == 'entregado' ? 'selected' : '' }}>Entregado</option>
                                                    <option value="devuelto" {{ $reserva->estado == 'devuelto' ? 'selected' : '' }}>Devuelto</option>
                                                </select>
                                            </td>   
                                            <td>
                                                <input type="number" class="form-control km-actual" data-id="{{ $reserva->id }}" value="{{ $reserva->km_actual }}">
                                            </td>  
                                            <td>
                                                <input type="number" class="form-control km-entregado" data-id="{{ $reserva->id }}" value="{{ $reserva->km_entregado }}">
                                            </td>  
                                            <td>
                                                <a href="{{ route('reservas-coche.edit', $reserva->id) }}" class="btn btn-primary">Editar</a>
                                                <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#confirmDeleteModal" data-id="{{ $reserva->id }}">Eliminar</button>

                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>

                            <div class="form-group mt-3">
                                <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addCocheSustitucionModal">
                                    <i class="fas fa-plus"></i> Añadir Coche de Sustitución
                                </button>
                                <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addReservaCocheModal">
                                    <i class="fas fa-plus"></i> Añadir Reserva de Coche de Sustitución
                                </button>
                            </div>
                        
                        {{-- <h3 class="mt-5 mb-2 text-center uppercase">Cliente Asociado</h3>
                        <hr class="mb-4">
                        <div class="form-group">
                            <select class="choices form-select" name="client_id">
                                @if ($clientes->count() > 0)
                                <option value="{{null}}">No existen clientes todavia</option>
                                    @foreach ( $clientes as $client )
                                        <option @if($client->id === $cliente->client_id) {{'selected'}} @endif value="{{$client->id}}">{{$client->name}}</option>
                                    @endforeach
                                @else
                                    <option value="{{null}}">No existen clientes todavia</option>
                                @endif
                            </select>
                        </div> --}}

                       

                        {{-- <h3 class="mt-5 mb-2 text-center uppercase">Contacto Asociado</h3>
                        <hr class="mb-4">

                        <div class="form-group">
                            <button id="newAssociatedContact" type="button" class="btn btn-secondary  mb-4"><i class="fa-solid fa-plus"></i> Agregar Contacto</button>
                            <h5 hidden id="labelAssociateNew" for="associated_contact_new" class="mb-2">Creación de nuevo/s contacto/s:</h5>
                            <div class="col-12 form-group" id="dynamic_field_associated_contact_new">
                            </div>
                        </div> --}}

                        <h3 class="mt-5 mb-2 text-center uppercase">Informacion de Contacto de la Empresa</h3>
                        <hr class="mb-4">
                        <div class="form-group">
                            <label for="email">Email de contacto:</label>
                            <input type="text" class="form-control @error('email') is-invalid @enderror" id="email" value="{{ old('email', $cliente->email) }}" name="email">
                            @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                        </div>
                        <button type="button" name="addMails" id="addExtraMail" class="btn btn-secondary mt-3"><i class="fas fa-plus"></i> Añadir email/s extra</button>
                        <br/>
                        <div class="col-12 form-group mt-4" id="dynamic_field_mails">
                        </div>
                        <div class="form-group">
                            <label for="phone">Teléfono movil:</label>
                            <input type="text" class="form-control @error('phone') is-invalid @enderror" id="phone" value="{{ old('phone', $cliente->phone) }}" name="phone">
                            @error('phone')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                        </div>
                        <button type="button" name="addExtraPhone" id="addExtraPhone" class="btn btn-secondary mt-3"><i class="fas fa-plus"></i> Añadir teléfono/s extra</button>
                        <div class="col-12 form-group mt-4" id="dynamic_field_phones">
                        </div>
                        {{-- <div class="form-group">
                            <label for="fax">Fax:</label>
                            <input type="text" class="form-control @error('fax') is-invalid @enderror" id="fax" value="{{ old('fax', $cliente->fax) }}" name="fax">
                            @error('fax')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                        </div> --}}

                        {{-- <h3 class="mt-5 mb-2 text-center uppercase">Redes Sociales - webs</h3>
                        <hr class="mb-4">

                        <div class="form-group">
                            <label for="web">Web:</label>
                            <input type="text" class="form-control @error('web') is-invalid @enderror" id="web" value="{{ old('web', $cliente->web) }}" name="web">
                            @error('web')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                        </div>
                        <button type="button" name="addWebs" id="addExtraWeb" class="btn btn-secondary mt-3"><i class="fas fa-plus"></i> Añadir web/s extra</button>
                        <div class="col-12 form-group mt-4" id="dynamic_field_webs">
                        </div> --}}

                        {{-- <h4 class="mt-5 mb-2 text-left uppercase">Redes Sociales</h4>
                        <div class="row form-group">
                            <div class="col-md-4 mb-3">
                                <label for="facebook"><i class="fa-brands fa-facebook"></i> Facebook:</label>
                                <input type="text" class="form-control @error('facebook') is-invalid @enderror" id="facebook" value="{{ old('facebook', $cliente->facebook) }}" name="facebook">
                                @error('facebook')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                @enderror
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="twitter"><i class="fa-brands fa-x-twitter"></i> Twitter:</label>
                                <input type="text" class="form-control @error('twitter') is-invalid @enderror" id="twitter" value="{{ old('twitter', $cliente->twitter) }}" name="twitter">
                                @error('twitter')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                @enderror
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="linkedin"><i class="fa-brands fa-linkedin"></i> Linkedin:</label>
                                <input type="text" class="form-control @error('linkedin') is-invalid @enderror" id="linkedin" value="{{ old('linkedin', $cliente->linkedin) }}" name="linkedin">
                                @error('linkedin')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                @enderror
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="instagram"><i class="fa-brands fa-square-instagram"></i> Instagram:</label>
                                <input type="text" class="form-control @error('instagram') is-invalid @enderror" id="instagram" value="{{ old('instagram', $cliente->instagram) }}" name="instagram">
                                @error('instagram')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                @enderror
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="pinterest"><i class="fa-brands fa-pinterest"></i> Pinterest:</label>
                                <input type="text" class="form-control @error('pinterest') is-invalid @enderror" id="pinterest" value="{{ old('pinterest', $cliente->pinterest) }}" name="pinterest">
                                @error('pinterest')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                @enderror
                            </div>
                        </div> --}}



                        <div class="form-group mt-5">
                            <button type="submit" class="btn btn-primary w-100">
                                {{ __('Actualizar') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </section>
        <div class="modal fade" id="addCarModal" tabindex="-1" aria-labelledby="addCarModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addCarModalLabel">Añadir Coche</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="addCarForm" action="{{ route('cliente.addCar') }}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="matricula" class="form-label">Matricula</label>
                                    <input type="text" class="form-control" id="matricula" name="matricula" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="vin" class="form-label">VIN</label>
                                    <input type="text" class="form-control" id="vin" name="vin" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="seguro" class="form-label">Seguro</label>
                                    <input type="text" class="form-control" id="seguro" name="seguro" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="marca" class="form-label">Marca</label>
                                    <input type="text" class="form-control" id="marca" name="marca" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="modelo" class="form-label">Modelo</label>
                                    <input type="text" class="form-control" id="modelo" name="modelo" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="anio" class="form-label">Año</label>
                                    <input type="number" class="form-control" id="anio" name="anio" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="km" class="form-label">Km</label>
                                    <input type="number" class="form-control" id="km" name="km" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="color" class="form-label">Color</label>
                                    <input type="text" class="form-control" id="color" name="color" required>
                                </div>
                                <input type="hidden" name="cliente_id" value="{{ $cliente->id }}">
                            </div>
                            <button type="submit" class="btn btn-primary">Guardar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="selectCarModal" tabindex="-1" aria-labelledby="selectCarModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="selectCarModalLabel">Seleccionar Coche</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <input type="text" id="searchCar" class="form-control" placeholder="Buscar por matrícula">
                        <ul id="carList" class="list-group mt-3">
                            @if ($allCoches->count() > 0)
                                @foreach ($allCoches as $coche)
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        {{ $coche->matricula }} - {{ $coche->marca }} {{ $coche->modelo }}
                                        <div>
                                            <a href="{{ route('coches.edit', $coche->id) }}" target="_blank" class="btn btn-primary btn-sm">Ver</a>
                                            @if ($coche->cliente_id)
                                                <a href="{{ route('clientes.edit', $coche->cliente_id) }}" target="_blank" class="btn btn-secondary btn-sm">Ver Cliente</a>
                                            @endif
                                            <button type="button" class="btn btn-primary btn-sm select-car" data-id="{{ $coche->id }}">Seleccionar</button>
                                        </div>
                                    </li>
                                @endforeach
                            @else
                                <li class="list-group-item">No se encontraron coches.</li>
                            @endif
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="confirmChangeClientModal" tabindex="-1" aria-labelledby="confirmChangeClientModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="confirmChangeClientModalLabel">Confirmación de Cambio de Cliente</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        El coche va a cambiar de cliente, ¿está seguro?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="button" class="btn btn-primary" id="confirmChangeClient">Confirmar</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="confirmRemoveCarModal" tabindex="-1" aria-labelledby="confirmRemoveCarModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="confirmRemoveCarModalLabel">Confirmación de Quitar Coche</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        ¿Estás seguro de que deseas quitar este coche del cliente?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="button" class="btn btn-primary" id="confirmRemoveCar">Confirmar</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal para añadir coche de sustitución -->
<div class="modal fade" id="addCocheSustitucionModal" tabindex="-1" aria-labelledby="addCocheSustitucionModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addCocheSustitucionModalLabel">Añadir Coche de Sustitución</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="addCocheSustitucionForm" action="{{ route('clientes.coche-sustitucion.store') }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="matricula" class="form-label">Matrícula</label>
                            <input type="text" class="form-control" id="matricula" name="matricula" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="vin" class="form-label">VIN</label>
                            <input type="text" class="form-control" id="vin" name="vin" >
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="seguro" class="form-label">Seguro</label>
                            <input type="text" class="form-control" id="seguro" name="seguro" >
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="marca" class="form-label">Marca</label>
                            <input type="text" class="form-control" id="marca" name="marca" >
                        </div>
                       
                        <div class="col-md-6 mb-3">
                            <label for="modelo" class="form-label">Modelo</label>
                            <input type="text" class="form-control" id="modelo" name="modelo" >
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="kilometraje" class="form-label">Kilometraje</label>
                            <input type="number" class="form-control" id="kilometraje" name="kilometraje" >
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="color" class="form-label">Color</label>
                            <input type="text" class="form-control" id="color" name="color" >
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="anio" class="form-label">Año</label>
                            <input type="number" class="form-control" id="anio" name="anio" >
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Guardar</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal para añadir reserva de coche de sustitución -->
<div class="modal fade" id="addReservaCocheModal" tabindex="-1" aria-labelledby="addReservaCocheModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addReservaCocheModalLabel">Añadir Reserva de Coche de Sustitución</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="addReservaCocheForm" action="{{ route('clientes.reserva-coche.store') }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="coche_sustitucion_id" class="form-label">Coche de Sustitución</label>
                            <select class="form-select" id="coche_sustitucion_id" name="coche_sustitucion_id" required>
                                @foreach($cochesSustitucion as $coche)
                                    <option value="{{ $coche->id }}">{{ $coche->marca }} - {{ $coche->modelo }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="estado" class="form-label">Estado</label>
                            <select class="form-select" id="estado" name="estado" required>
                                <option value="pendiente">Pendiente</option>
                                <option value="entregado">Entregado</option>
                                <option value="devuelto">Devuelto</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="fecha_inicio" class="form-label">Fecha de Inicio</label>
                            <input type="date" class="form-control" id="fecha_inicio" name="fecha_inicio" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="fecha_fin" class="form-label">Fecha de Fin</label>
                            <input type="date" class="form-control" id="fecha_fin" name="fecha_fin" >
                        </div>
                        
                        
                        <div class="col-md-6 mb-3">
                            <label for="km_actual" class="form-label">Kilometraje Actual</label>
                            <input type="number" class="form-control" id="km_actual" name="km_actual" >
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="km_entregado" class="form-label">Kilometraje Entregado</label>
                            <input type="number" class="form-control" id="km_entregado" name="km_entregado" >
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="comentario" class="form-label">Comentario</label>
                            <textarea class="form-control" id="comentario" name="comentario"></textarea>
                        </div>
                        <input type="hidden" name="cliente_id" value="{{ $cliente->id }}">
                    </div>
                    <button type="submit" class="btn btn-primary">Guardar</button>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-labelledby="confirmDeleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmDeleteModalLabel">Confirmación de Eliminación</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                ¿Estás seguro de que deseas eliminar esta reserva de coche de sustitución?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-danger" id="confirmDeleteButton">Eliminar</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="successModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="successModalLabel">Éxito</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Reserva actualizada con éxito.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>
        <div id="alert-container" class="mt-3"></div>
    </div>

@endsection

@section('scripts')
<script src="{{asset('assets/vendors/choices.js/choices.min.js')}}"></script>
<script>
    $(document).ready(function() {
        var i=1;
        $('#newAssociatedContact').click(function(){
            i++;
            $('#dynamic_field_associated_contact_new').append('<div class="col-12 new-associate-contact" id="createAssociatedContact'+i+'"><div class="input-group list-row-new-associated-contact" ><input  name="newAssociatedContact['+i+'][name]" type="text" placeholder="Nombre completo" class="form-control">&nbsp;&nbsp;<input  name="newAssociatedContact['+i+'][email]" type="text"placeholder="Email" class="form-control">&nbsp;&nbsp;<input  name="newAssociatedContact['+i+'][telephone]" type="text"placeholder="Teléfono" class="form-control">&nbsp;<button type="button" name="remove"  id="'+i+'" class="btn btn-danger btn_remove_new_associated_contact">X</button></div><br></div>');

            $('#labelAssociateNew').attr('hidden', false);

        });
        $(document).on('click', '.btn_remove_new_associated_contact', function(){
            var button_rem_id = $(this).attr("id");
            $('#createAssociatedContact'+button_rem_id+'').remove();
            if($('.new-associate-contact').length === 0){
                $('#labelAssociateNew').attr('hidden', true);
            }
        });

        // Función para mostrar/ocultar campos
        function toggleFields() {
            if ($('#particular').is(':checked')) {
                $('#activity').closest('.form-group').hide();
                $('#identifier').closest('.form-group').hide();
                $('#company').closest('.form-group').hide();
            } else {
                $('#activity').closest('.form-group').show();
                $('#identifier').closest('.form-group').show();
                $('#company').closest('.form-group').show();
            }
        }

        // Llamar a la función al cargar la página
        toggleFields();

        // Llamar a la función cuando se cambia el tipo de cliente
        $('input[name="tipoCliente"]').change(function() {
            toggleFields();
        });

        $('#searchCar').on('keyup', function() {
            var query = $(this).val();
            $.ajax({
                url: '{{ route("search.cars") }}',
                type: 'GET',
                data: { query: query , cliente_id: {{ $cliente->id }} },
                success: function(data) {
                    $('#carList').empty();
                    if(data.length > 0){
                    data.forEach(function(coche) {
                        $('#carList').append(
                            `<li class="list-group-item d-flex justify-content-between align-items-center">
                                ${coche.matricula} - ${coche.marca} ${coche.modelo}
                                <div>
                                    <a href="{{ route('coches.edit', $coche->id) }}" target="_blank" class="btn btn-primary btn-sm">Ver</a>
                                    @if ($coche->cliente_id)
                                        <a href="{{ route('clientes.edit', $coche->cliente_id) }}" target="_blank" class="btn btn-secondary btn-sm">Ver Cliente</a>
                                    @endif
                                    <button type="button" class="btn btn-primary btn-sm select-car" data-id="${coche.id}">Seleccionar</button>
                                </div>
                            </li>`
                        );
                    });
                    }else{
                        $('#carList').append(
                            `<li class="list-group-item">No se encontraron coches.</li>`
                        );
                    }
                }
            });
        });

        $(document).on('click', '.select-car', function() {
            var carId = $(this).data('id');
            var hasClient = $(this).siblings('a.btn-secondary').length > 0;

            if (hasClient) {
                $('#confirmChangeClientModal').modal('show');
                $('#confirmChangeClient').off('click').on('click', function() {
                    changeClient(carId);
                });
            } else {
                // Directly assign the car to the client if it has no client
                changeClient(carId);
            }
        });

        function changeClient(carId) {
            $.ajax({
                url: '{{ route("coches.changeClient") }}',
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    coche_id: carId,
                    new_cliente_id: {{ $cliente->id }}
                },
                success: function(response) {
                    console.log(response); // Verificar la respuesta del servidor
                    if (response.success) {
                        $('#alert-container').html(`
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                ${response.message}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        `);
                        setTimeout(function() {
                            location.reload(); // Recargar la página después de un breve retraso
                        }, 300);
                    } else {
                        alert(response.message);
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error en la solicitud AJAX:', error);
                }
            });
        }

        // Evento para quitar coche
        var carIdToRemove;
        $(document).on('click', '.remove-car', function() {
            carIdToRemove = $(this).data('id');
            $('#confirmRemoveCarModal').modal('show');
        });

        $('#confirmRemoveCar').click(function() {
            $.ajax({
                url: '{{ route("coches.removeClient") }}',
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    coche_id: carIdToRemove
                },
                success: function(response) {
                    if (response.success) {
                        $('#alert-container').html(`
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                ${response.message}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        `);
                        setTimeout(function() {
                            location.reload(); // Recargar la página después de un breve retraso
                        }, 300);
                    } else {
                        alert(response.message);
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error en la solicitud AJAX:', error);
                }
            });
            $('#confirmRemoveCarModal').modal('hide');
        });
    });
        // Mails extra
    $(document).ready(function() {
        var i=1;
        $('#addExtraMail').click(function(){
            i++;
            $('#dynamic_field_mails').append('<div id="rowMail'+i+'" class="row"><div class="col-md-10"><input type="text" style="margin-bottom:2%" name="mails[]" placeholder="" class="form-control name_list" /></div><div class="col-md-2"><button type="button" name="remove" id="'+i+'" class="btn btn-danger btn_remove_mail">X</button></div></div>');

        });
        $(document).on('click', '.btn_remove_mail', function(){
            var button_id = $(this).attr("id");
            $('#rowMail'+button_id+'').remove();
        });
    });
    // Teléfonos extra
    $(document).ready(function() {
        var i=1;
        $('#addExtraPhone').click(function(){
            i++;
            $('#dynamic_field_phones').append('<div id="rowPhone'+i+'" class="dynamic-added row"><div class="col-md-10"><input type="text" style="margin-bottom:2%" name="numbers[]" placeholder="" class="form-control name_list" /></div><div class="col-md-2"><button type="button" name="remove" id="'+i+'" class="btn btn-danger btn_remove_phone">X</button></div></div>');
        });
        $(document).on('click', '.btn_remove_phone', function(){
            var button_id = $(this).attr("id");
            $('#rowPhone'+button_id+'').remove();
        });
    });
    // webs extra
    $(document).ready(function() {
        var i=1;
        $('#addExtraWeb').click(function(){
            i++;
            $('#dynamic_field_webs').append('<div id="rowWeb'+i+'" class="dynamic-added row"><div class="col-md-10"><input type="text" style="margin-bottom:2%" name="webs[]" placeholder="" class="form-control name_list" /></div><div class="col-md-2"><button type="button" name="remove" id="'+i+'" class="btn btn-danger btn_remove_web">X</button></div></div>');

        });
        $(document).on('click', '.btn_remove_web', function(){
            var button_id = $(this).attr("id");
            $('#rowWeb'+button_id+'').remove();
        });
    });

</script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var today = new Date().toISOString().split('T')[0];
        document.getElementById('fecha_inicio').value = today;
    });
</script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var deleteForm;
        var confirmDeleteButton = document.getElementById('confirmDeleteButton');

        $('#confirmDeleteModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget); // Botón que activó el modal
            var reservaId = button.data('id'); // Extraer información de los atributos data-*
            deleteForm = document.getElementById('delete-form-' + reservaId);
        });

        confirmDeleteButton.addEventListener('click', function() {
            if (deleteForm) {
                deleteForm.submit();
            }
        });
    });
</script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Cambiar estado de la reserva
        $('.estado-reserva').change(function() {
            var reservaId = $(this).data('id');
            var nuevoEstado = $(this).val();
            actualizarReserva(reservaId, { estado: nuevoEstado });
        });

        // Cambiar fecha de fin de la reserva
        $('.fecha-fin').change(function() {
            var reservaId = $(this).data('id');
            var nuevaFechaFin = $(this).val();
            actualizarReserva(reservaId, { fecha_fin: nuevaFechaFin });
        });
        // Cambiar kilometraje actual de la reserva
        $('.km-actual').change(function() {
            var reservaId = $(this).data('id');
            var nuevoKmActual = $(this).val();
            actualizarReserva(reservaId, { km_actual: nuevoKmActual });
        });

        // Cambiar kilometraje entregado de la reserva
        $('.km-entregado').change(function() {
            var reservaId = $(this).data('id');
            var nuevoKmEntregado = $(this).val();
            actualizarReserva(reservaId, { km_entregado: nuevoKmEntregado });
        });
        function actualizarReserva(reservaId, data) {
            $.ajax({
                url: '{{ url("/clientes/reserva-coche") }}/' + reservaId,
                type: 'PUT',
                data: {
                    _token: '{{ csrf_token() }}',
                    ...data
                },
                success: function(response) {
                    $('#successModal').modal('show');
                },
                error: function(xhr, status, error) {
                    console.error('Error al actualizar la reserva:', error);
                    alert('Hubo un error al actualizar la reserva.');
                }
            });
        }
    });
</script>

@endsection
@foreach ($reservasCoche as $reserva)
    <form id="delete-form-{{ $reserva->id }}" action="{{ route('clientes.reserva-coche.destroy', $reserva->id) }}" method="POST" style="display: none;">
        @csrf
        @method('DELETE')
    </form>
@endforeach
