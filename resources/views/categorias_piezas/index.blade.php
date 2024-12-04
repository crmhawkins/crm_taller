@extends('layouts.app')

@section('titulo', 'Categorías de Piezas')

@section('css')
<link rel="stylesheet" href="assets/vendors/simple-datatables/style.css">
@endsection

@section('content')

<div class="page-heading card" style="box-shadow: none !important">

    {{-- Titulos --}}
    <div class="page-title card-body p-3">
        <div class="row justify-content-between">
            <div class="col-12 col-md-4 order-md-1 order-first">
                <h3><i class="bi bi-tags"></i> Categorías de Piezas</h3>
                <p class="text-subtitle text-muted">Listado de categorías de piezas</p>
            </div>

            <div class="col-12 col-md-4 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Categorías de Piezas</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <section class="section pt-4">
        <div class="card">
            <div class="card-body">
                <div class="mb-3">
                    <a href="{{ route('categorias-piezas.create') }}" class="btn btn-primary">Añadir Categoría</a>
                </div>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Descripción</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($categorias as $categoria)
                            <tr>
                                <td>{{ $categoria->nombre }}</td>
                                <td>{{ $categoria->descripcion }}</td>
                                <td>
                                    <a href="{{ route('categorias-piezas.show', $categoria->id) }}" class="btn btn-info btn-sm">Ver</a>
                                    <a href="{{ route('categorias-piezas.edit', $categoria->id) }}" class="btn btn-warning btn-sm">Editar</a>
                                    <form action="{{ route('categorias-piezas.destroy', $categoria->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">Eliminar</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </section>

</div>
@endsection

@section('scripts')
    @include('partials.toast')
@endsection 