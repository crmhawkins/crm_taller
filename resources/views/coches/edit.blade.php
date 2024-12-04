@extends('layouts.app')

@section('titulo', 'Editar Coche')

@section('css')
<link rel="stylesheet" href="assets/vendors/simple-datatables/style.css">
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
@endsection

@section('content')

    <div class="page-heading card" style="box-shadow: none !important">

        {{-- Titulos --}}
        <div class="page-title card-body p-3">
            <div class="row justify-content-between">
                <div class="col-12 col-md-4 order-md-1 order-first">
                    <h3><i class="bi bi-car-front"></i> Editar Coche</h3>
                </div>
            </div>
        </div>

        <section class="section pt-4">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('coches.update', $coche->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="form-group mb-3">
                            <label for="matricula">Matrícula:</label>
                            <input type="text" name="matricula" class="form-control" value="{{ $coche->matricula }}" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="vin">VIN:</label>
                            <input type="text" name="vin" class="form-control" value="{{ $coche->vin }}" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="seguro">Seguro:</label>
                            <input type="text" name="seguro" class="form-control" value="{{ $coche->seguro }}" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="marca">Marca:</label>
                            <input type="text" name="marca" class="form-control" value="{{ $coche->marca }}" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="modelo">Modelo:</label>
                            <input type="text" name="modelo" class="form-control" value="{{ $coche->modelo }}" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="anio">Año:</label>
                            <input type="number" name="anio" class="form-control" value="{{ $coche->anio }}">
                        </div>
                        <div class="form-group mb-3">
                            <label for="kilometraje">Kilometraje:</label>
                            <input type="number" name="kilometraje" class="form-control" value="{{ $coche->kilometraje }}" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="color">Color:</label>
                            <input type="text" name="color" class="form-control" value="{{ $coche->color }}">
                        </div>
                        <div class="form-group mb-3">
                            <label for="cliente_id">Cliente:</label>
                            <select name="cliente_id" class="form-control select2" required>
                                <option value="">Seleccione un cliente</option>
                                @foreach($clientes as $cliente)
                                    <option value="{{ $cliente->id }}" {{ $coche->cliente_id == $cliente->id ? 'selected' : '' }}>
                                        {{ $cliente->name }} {{ $cliente->lastname }} - {{ $cliente->cif }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">Actualizar</button>
                    </form>
                </div>
            </div>
        </section>

    </div>
@endsection

@section('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
<script>
    $(document).ready(function() {
        $('.select2').select2();
    });
</script>
@include('partials.toast')
@endsection
