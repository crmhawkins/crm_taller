@extends('layouts.app')

@section('titulo', 'Seguros')

@section('content')

    <div class="page-heading card" style="box-shadow: none !important">

        <div class="page-title card-body p-3">
            <h3>Seguros</h3>
            <p class="text-subtitle text-muted">Listado de seguros</p>
        </div>

        <section class="section pt-4">
            <div class="card">
                <div class="card-body">
                    <div class="mb-3">
                        <a href="{{ route('seguro.create') }}" class="btn btn-primary">Añadir Seguro</a>
                    </div>
                    @livewire('seguro-table')
                </div>
            </div>
        </section>

    </div>
@endsection 