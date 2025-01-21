@extends('layouts.app')

@section('titulo', 'Visitas de Coches')

@section('content')

    <div class="page-heading card" style="box-shadow: none !important">

        <div class="page-title card-body p-3">
            <h3>Visitas de Coches</h3>
            <p class="text-subtitle text-muted">Listado de visitas de coches</p>
        </div>

        <section class="section pt-4">
            <div class="card">
                <div class="card-body">
                    <div class="mb-3">
                        <a href="{{ route('visitas.create') }}" class="btn btn-primary">Nueva Visita</a>
                    </div>
                    <livewire:visitas-table />
                </div>
            </div>
        </section>

    </div>
@endsection 