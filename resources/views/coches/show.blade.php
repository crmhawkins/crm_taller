@extends('layouts.app')

@section('titulo', 'Detalles del Coche')

@section('css')
<link rel="stylesheet" href="assets/vendors/simple-datatables/style.css">
@endsection

@section('content')

    <div class="page-heading card" style="box-shadow: none !important">

        {{-- Titulos --}}
        <div class="page-title card-body p-3">
            <div class="row justify-content-between">
                <div class="col-12 col-md-4 order-md-1 order-first">
                    <h3><i class="bi bi-car-front"></i> Detalles del Coche</h3>
                </div>
            </div>
        </div>

        <section class="section pt-4">
            <div class="card">
                <div class="card-body">
                    <p><strong>Matrícula:</strong> {{ $coche->matricula }}</p>
                    <p><strong>Seguro:</strong> {{ $coche->seguro }}</p>
                    <p><strong>Marca:</strong> {{ $coche->marca }}</p>
                    <p><strong>VIN:</strong> {{ $coche->vin }}</p>
                    <p><strong>Modelo:</strong> {{ $coche->modelo }}</p>
                    <p><strong>Kilometraje:</strong> {{ $coche->kilometraje }}</p>
                    <p><strong>Color:</strong> {{ $coche->color }}</p>
                    <p><strong>Año:</strong> {{ $coche->anio }}</p>
                    <p><strong>Cliente ID:</strong> {{ $coche->cliente_id }}</p>
                    <a href="{{ route('coches.index') }}" class="btn btn-secondary">Volver a la lista</a>
                </div>
            </div>
        </section>

    </div>
@endsection

@section('scripts')
    @include('partials.toast')
@endsection
