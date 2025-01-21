@extends('layouts.app')

@section('titulo', 'Siniestros')

@section('content')

    <div class="page-heading card" style="box-shadow: none !important">

        <div class="page-title card-body p-3">
            <h3>Partes de Trabajo</h3>
            <p class="text-subtitle text-muted">Listado de partes de trabajo</p>
        </div>

        <section class="section pt-4">
            <div class="card">
                <div class="card-body">
                    <div class="mb-3">
                        <a href="{{ route('siniestro.create') }}" class="btn btn-primary">Añadir Parte de Trabajo</a>
                        @if(request()->has('coche_id') || request()->has('cliente_id'))
                            <a href="{{ route('siniestro.index') }}" class="btn btn-secondary">Eliminar Filtros</a>
                        @endif
                    </div>
                    @livewire('siniestro-table', ['coche_id' => request()->coche_id, 'cliente_id' => request()->cliente_id])
                </div>
            </div>
        </section>

    </div>
@endsection 