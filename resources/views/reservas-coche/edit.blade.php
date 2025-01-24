@extends('layouts.app')

@section('titulo', 'Editar Reserva de Coche')

@section('css')
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
@endsection


@section('content')
    <div class="page-heading card" style="box-shadow: none !important">
        <div class="page-title card-body p-3">
            <div class="row justify-content-between">
                <div class="col-12 col-md-4 order-md-1 order-first">
                    <h3><i class="bi bi-calendar-edit"></i> Editar Reserva de Coche</h3>
                </div>
            </div>
        </div>

        <section class="section pt-4">
            <div class="card">
                <div class="card-body">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('reservas-coche.update', $reservasCoche->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="form-group mb-3 col-md-3">
                                <label for="coche_sustitucion_id">Coche de Sustitución:</label>
                                <select name="coche_sustitucion_id" class="form-control select2" id="coche_sustitucion_id" required>
                                <option value="">Seleccione un coche</option>
                                @foreach($coches as $coche)
                                    <option value="{{ $coche->id }}" {{ $reservasCoche->coche_sustitucion_id == $coche->id ? 'selected' : '' }}>
                                        {{ $coche->matricula }} - {{ $coche->marca }} {{ $coche->modelo }}
                                    </option>
                                @endforeach
                                </select>
                            </div>
                            <div class="form-group mb-3 col-md-3">
                                <label for="cliente_id">Cliente:</label>
                                <select name="cliente_id" class="form-control select2" id="cliente_id" required>
                                <option value="">Seleccione un cliente</option>
                                @foreach($clientes as $cliente)
                                    <option value="{{ $cliente->id }}" {{ $reservasCoche->cliente_id == $cliente->id ? 'selected' : '' }}>
                                        {{ $cliente->name }} {{ $cliente->lastname }}
                                    </option>
                                @endforeach
                            </select>
                            </div>
                            <div class="form-group mb-3 col-md-3">
                                <label for="fecha_inicio">Fecha de Inicio:</label>
                                <input type="date" name="fecha_inicio" class="form-control" value="{{ $reservasCoche->fecha_inicio }}" required>
                            </div>
                            <div class="form-group mb-3 col-md-3">
                                <label for="fecha_fin">Fecha de Fin:</label>
                                <input type="date" name="fecha_fin" class="form-control" value="{{ $reservasCoche->fecha_fin }}" >
                            </div>
                            <div class="form-group mb-3 col-md-3">
                                <label for="km_actual">Kilómetros Actuales:</label>
                                <input type="number" name="km_actual" class="form-control" value="{{ $reservasCoche->km_actual }}" required>
                            </div>
                            <div class="form-group mb-3 col-md-3">
                                <label for="km_entregado">Kilómetros Entregado:</label>
                                <input type="number" name="km_entregado" class="form-control" value="{{ $reservasCoche->km_entregado }}">
                            </div>
                            <div class="form-group mb-3 col-md-3">
                                <label for="estado">Estado:</label>
                                <select name="estado" class="form-control" required>
                                    <option value="pendiente" {{ $reservasCoche->estado == 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                                <option value="entregado" {{ $reservasCoche->estado == 'entregado' ? 'selected' : '' }}>Entregado</option>
                                <option value="devuelto" {{ $reservasCoche->estado == 'devuelto' ? 'selected' : '' }}>Devuelto</option>
                            </select>
                            </div>
                            <div class="form-group mb-3 col-md-3">
                                <label for="comentario">Comentario:</label>
                                <textarea name="comentario" class="form-control">{{ $reservasCoche->comentario }}</textarea>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">Actualizar</button>
                    </form>
                </div>
            </div>
        </section>
    </div>
@endsection

@section('scripts')
    @include('partials.toast')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.select2').select2();
        });
    </script>
@endsection 