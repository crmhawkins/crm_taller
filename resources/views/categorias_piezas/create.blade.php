@extends('layouts.app')

@section('titulo', 'Añadir Categoría de Pieza')

@section('css')
<link rel="stylesheet" href="assets/vendors/simple-datatables/style.css">
@endsection

@section('content')

<div class="page-heading card" style="box-shadow: none !important">

    {{-- Titulos --}}
    <div class="page-title card-body p-3">
        <div class="row justify-content-between">
            <div class="col-12 col-md-4 order-md-1 order-first">
                <h3><i class="bi bi-tags"></i> Añadir Categoría de Pieza</h3>
                <p class="text-subtitle text-muted">Formulario para añadir una nueva categoría de pieza</p>
            </div>

            <div class="col-12 col-md-4 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('categorias-piezas.index') }}">Categorías de Piezas</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Añadir</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <section class="section pt-4">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('categorias-piezas.store') }}" method="POST">
                    @csrf
                    <div class="form-group mb-3">
                        <label for="nombre">Nombre:</label>
                        <input type="text" name="nombre" class="form-control" required>
                    </div>
                    <div class="form-group mb-3">
                        <label for="descripcion">Descripción:</label>
                        <textarea name="descripcion" class="form-control"></textarea>
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