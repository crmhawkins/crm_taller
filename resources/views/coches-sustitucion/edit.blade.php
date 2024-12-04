@extends('layouts.app')

@section('titulo', 'Editar Coche de Sustitución')

@section('content')
    <div class="page-heading card" style="box-shadow: none !important">
        <div class="page-title card-body p-3">
            <div class="row justify-content-between">
                <div class="col-12 col-md-4 order-md-1 order-first">
                    <h3><i class="bi bi-car-front"></i> Editar Coche de Sustitución</h3>
                </div>
            </div>
        </div>

        <section class="section pt-4">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('coches-sustitucion.update', $cochesSustitucion->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="form-group mb-3">
                            <label for="matricula">Matrícula:</label>
                            <input type="text" name="matricula" class="form-control" value="{{ $cochesSustitucion->matricula }}" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="seguro">Seguro:</label>
                            <input type="text" name="seguro" class="form-control" value="{{ $cochesSustitucion->seguro }}">
                        </div>
                        <div class="form-group mb-3">
                            <label for="marca">Marca:</label>
                            <input type="text" name="marca" class="form-control" value="{{ $cochesSustitucion->marca }}" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="vin">VIN:</label>
                            <input type="text" name="vin" class="form-control" value="{{ $cochesSustitucion->vin }}">
                        </div>
                        <div class="form-group mb-3">
                            <label for="modelo">Modelo:</label>
                            <input type="text" name="modelo" class="form-control" value="{{ $cochesSustitucion->modelo }}" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="kilometraje">Kilometraje:</label>
                            <input type="number" name="kilometraje" class="form-control" value="{{ $cochesSustitucion->kilometraje }}" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="color">Color:</label>
                            <input type="text" name="color" class="form-control" value="{{ $cochesSustitucion->color }}">
                        </div>
                        <div class="form-group mb-3">
                            <label for="anio">Año:</label>
                            <input type="number" name="anio" class="form-control" value="{{ $cochesSustitucion->anio }}">
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
@endsection