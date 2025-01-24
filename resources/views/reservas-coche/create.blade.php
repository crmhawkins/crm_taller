@extends('layouts.app')

@section('titulo', 'Añadir Reserva de Coche')

@section('content')
@section('css')
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
@endsection
    <div class="page-heading card" style="box-shadow: none !important">
        <div class="page-title card-body p-3">
            <div class="row justify-content-between">
                <div class="col-12 col-md-4 order-md-1 order-first">
                    <h3><i class="bi bi-calendar-plus"></i> Añadir Reserva de Coche</h3>
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

                    <form action="{{ route('reservas-coche.store') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="form-group mb-3 col-md-3">
                                <label for="coche_sustitucion_id">Coche de Sustitución:</label>
                                <select name="coche_sustitucion_id" class="form-control select2" id="coche_sustitucion_id" required>
                                    <option value="">Seleccione un coche</option>
                                @foreach($coches as $coche)
                                    <option value="{{ $coche->id }}">{{ $coche->matricula }} - {{ $coche->marca }} {{ $coche->modelo }}</option>
                                @endforeach
                                </select>
                            </div>
                            <div class="form-group mb-3 col-md-3">
                                <label for="cliente_id">Cliente:</label>
                                <select name="cliente_id" class="form-control select2" id="cliente_id" required>
                                <option value="">Seleccione un cliente</option>
                                @foreach($clientes as $cliente)
                                <option value="{{ $cliente->id }}" {{ request('cliente_id') == $cliente->id ? 'selected' : '' }}>
                                    {{ $cliente->name }} {{ $cliente->lastname }}
                                </option>                                @endforeach
                            </select>
                            </div>
                            <div class="form-group mb-3 col-md-3">
                                <label for="fecha_inicio">Fecha de Inicio:</label>
                                <input type="date" name="fecha_inicio" class="form-control" required value="{{ date('Y-m-d') }}">
                            </div>
                            <div class="form-group mb-3 col-md-3">
                            <label for="fecha_fin">Fecha de Fin:</label>
                            <input type="date" name="fecha_fin" class="form-control" >
                            </div>
                            <div class="form-group mb-3 col-md-3">
                                <label for="km_actual">Kilómetros Actuales:</label>
                                <input type="number" name="km_actual" class="form-control" required>
                            </div>
                            <div class="form-group mb-3 col-md-3">
                            <label for="km_entregado">Kilómetros Entregado:</label>
                            <input type="number" name="km_entregado" class="form-control">
                            </div>
                            <div class="form-group mb-3 col-md-3">
                                <label for="estado">Estado:</label>
                                <select name="estado" class="form-control" required>
                                    <option value="pendiente">Pendiente</option>
                                <option value="entregado">Entregado</option>
                                <option value="devuelto">Devuelto</option>
                                </select>
                            </div>
                            <div class="form-group mb-3 col-md-3">
                                <label for="comentario">Comentario:</label>
                                <textarea name="comentario" class="form-control"></textarea>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">Guardar</button>
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