@extends('layouts.app')

@section('titulo', 'Añadir Coche de Sustitución')

@section('content')
    <div class="page-heading card" style="box-shadow: none !important">
        <div class="page-title card-body p-3">
            <div class="row justify-content-between">
                <div class="col-12 col-md-4 order-md-1 order-first">
                    <h3><i class="bi bi-car-front"></i> Añadir Coche de Sustitución</h3>
                </div>
            </div>
        </div>

        <section class="section pt-4">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('coches-sustitucion.store') }}" method="POST">
                        @csrf
                        <div class="form-group mb-3">
                            <label for="matricula">Matrícula:</label>
                            <input type="text" name="matricula" class="form-control" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="seguro">Seguro:</label>
                            <input type="text" name="seguro" class="form-control">
                        </div>
                        <div class="form-group mb-3">
                            <label for="marca">Marca:</label>
                            <input type="text" name="marca" class="form-control" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="vin">VIN:</label>
                            <input type="text" name="vin" class="form-control">
                        </div>
                        <div class="form-group mb-3">
                            <label for="modelo">Modelo:</label>
                            <input type="text" name="modelo" class="form-control" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="kilometraje">Kilometraje:</label>
                            <input type="number" name="kilometraje" class="form-control" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="color">Color:</label>
                            <input type="text" name="color" class="form-control">
                        </div>
                        <div class="form-group mb-3">
                            <label for="anio">Año:</label>
                            <input type="number" name="anio" class="form-control">
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
@endsection 