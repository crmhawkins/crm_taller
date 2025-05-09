@extends('layouts.app')

@section('titulo', 'Hojas de Inspección')

@section('css')
<link rel="stylesheet" href="assets/vendors/simple-datatables/style.css">
@endsection

@section('content')

    <div class="page-heading card" style="box-shadow: none !important">

        {{-- Titulos --}}
        <div class="page-title card-body p-3">
            <div class="row justify-content-between">
                <div class="col-12 col-md-4 order-md-1 order-first">
                    <h3><i class="bi bi-file-earmark-text"></i> Hojas de Inspección</h3>
                    <p class="text-subtitle text-muted">Listado de hojas de inspección para {{ $coche->matricula }}</p>
                </div>

                <div class="col-12 col-md-4 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Dashboard</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Hojas de Inspección</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>

        <section class="section pt-4">
            <div class="card">
                <div class="card-body">
                    <div class="mb-3">
                        <a href="{{ route('hojas_inspeccion.create', $coche->id) }}" class="btn btn-primary">Crear Nueva Hoja de Inspección</a>
                    </div>
                    @livewire('hojas-inspeccion-table', ['cocheId' => $coche->id])
                </div>
            </div>
        </section>

    </div>
@endsection

@section('scripts')
    @include('partials.toast')
@endsection 