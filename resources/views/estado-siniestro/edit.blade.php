@extends('layouts.app')

@section('titulo', 'Editar Estado de Siniestro')

@section('content')

    <div class="page-heading card" style="box-shadow: none !important">

        <div class="page-title card-body p-3">
            <h3>Editar Estado de Siniestro</h3>
        </div>

        <section class="section pt-4">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('estado-siniestro.update', $estadoSiniestro->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="estado">Estado</label>
                            <input type="text" class="form-control" id="estado" name="estado" value="{{ old('estado', $estadoSiniestro->estado) }}" required>
                        </div>
                        <button type="submit" class="btn btn-primary mt-3">Actualizar</button>
                    </form>
                </div>
            </div>
        </section>

    </div>
@endsection
