@extends('layouts.app')

@section('titulo', 'Detalles de la Pieza')

@section('content')

<div class="page-heading card" style="box-shadow: none !important">

    {{-- Titulos --}}
    <div class="page-title card-body p-3">
        <div class="row justify-content-between">
            <div class="col-12 col-md-4 order-md-1 order-first">
                <h3><i class="bi bi-gear"></i> Detalles de la Pieza</h3>
            </div>
        </div>
    </div>

    <section class="section pt-4">
        <div class="card">
            <div class="card-body">
                <p><strong>Nombre:</strong> {{ $pieza->nombre }}</p>
                <p><strong>Código:</strong> {{ $pieza->codigo }}</p>
                <p><strong>Fabricante:</strong> {{ $pieza->fabricante }}</p>
                <p><strong>Marca:</strong> {{ $pieza->marca }}</p>
                <p><strong>Modelo:</strong> {{ $pieza->modelo }}</p>
                <p><strong>Descripción:</strong> {{ $pieza->descripcion }}</p>
                <p><strong>Nota:</strong> {{ $pieza->nota }}</p>
                <p><strong>Proveedor:</strong> {{ $pieza->proveedor ? $pieza->proveedor->nombre : 'N/A' }}</p>
                <p><strong>Número de Serie:</strong> {{ $pieza->numero_serie }}</p>
                <p><strong>Categoría:</strong> {{ $pieza->categoria ? $pieza->categoria->nombre : 'N/A' }}</p>
                <a href="{{ route('piezas.index') }}" class="btn btn-secondary">Volver a la lista</a>
            </div>
        </div>
    </section>

</div>
@endsection
