@extends('layouts.app')

@section('titulo', 'Siniestros')

@section('content')

    <div class="page-heading card" style="box-shadow: none !important">

        <div class="page-title card-body p-3">
            <h3>Siniestros</h3>
            <p class="text-subtitle text-muted">Listado de siniestros</p>
        </div>

        <section class="section pt-4">
            <div class="card">
                <div class="card-body">
                    <div class="mb-3">
                        <a href="{{ route('siniestro.create') }}" class="btn btn-primary">Añadir Siniestro</a>
                    </div>
                    @livewire('siniestro-table')
                </div>
            </div>
        </section>

    </div>
@endsection 