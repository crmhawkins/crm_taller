@extends('layouts.app')

@section('titulo', 'Piezas')

@section('css')
<link rel="stylesheet" href="assets/vendors/simple-datatables/style.css">
@endsection

@section('content')

<div class="page-heading card" style="box-shadow: none !important">

    {{-- Titulos --}}
    <div class="page-title card-body p-3">
        <div class="row justify-content-between">
            <div class="col-12 col-md-4 order-md-1 order-first">
                <h3><i class="bi bi-gear"></i> Piezas</h3>
                <p class="text-subtitle text-muted">Listado de piezas</p>
            </div>

            <div class="col-12 col-md-4 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Piezas</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <section class="section pt-4">
        <div class="card">
            <div class="card-body">
                <div class="mb-3">
                    <a href="{{ route('piezas.create') }}" class="btn btn-primary">Añadir Pieza</a>
                </div>
                @livewire('piezas-table')
            </div>
        </div>
    </section>

</div>
@endsection

@section('scripts')
    @include('partials.toast')
@endsection
