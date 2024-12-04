@extends('layouts.app')

@section('titulo', 'Detalles de la Categoría de Pieza')

@section('css')
<link rel="stylesheet" href="assets/vendors/simple-datatables/style.css">
@endsection

@section('content')

<div class="page-heading card" style="box-shadow: none !important">

    {{-- Titulos --}}
    <div class="page-title card-body p-3">
        <div class="row justify-content-between">
            <div class="col-12 col-md-4 order-md-1 order-first">
                <h3><i class="bi bi-tags"></i> Detalles de la Categoría de Pieza</h3>
                <p class="text-subtitle text-muted">Información detallada de la categoría de pieza</p>
            </div>

            <div class="col-12 col-md-4 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('categorias-piezas.index') }}">Categorías de Piezas</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Detalles</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <section class="section pt-4">
        <div class="card">
            <div class="card-body">
                <p><strong>Nombre:</strong> {{ $categoria->nombre }}</p>
                <p><strong>Descripción:</strong> {{ $categoria->descripcion }}</p>
                <a href="{{ route('categorias-piezas.index') }}" class="btn btn-secondary">Volver a la lista</a>
            </div>
        </div>
    </section>

</div>
@endsection

@section('scripts')
    @include('partials.toast')
@endsection 