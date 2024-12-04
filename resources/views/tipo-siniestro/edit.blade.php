@extends('layouts.app')

@section('titulo', 'Editar Tipo de Siniestro')

@section('content')

    <div class="page-heading card" style="box-shadow: none !important">

        <div class="page-title card-body p-3">
            <h3>Editar Tipo de Siniestro</h3>
        </div>

        <section class="section pt-4">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('tipo-siniestro.update', $tipoSiniestro->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="tipo">Tipo</label>
                            <input type="text" class="form-control" id="tipo" name="tipo" value="{{ old('tipo', $tipoSiniestro->tipo) }}" required>
                        </div>
                        <button type="submit" class="btn btn-primary mt-3">Actualizar</button>
                    </form>
                </div>
            </div>
        </section>

    </div>
@endsection
