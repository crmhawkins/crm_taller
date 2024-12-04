@extends('layouts.app')

@section('titulo', 'Editar Seguro')

@section('content')

    <div class="page-heading card" style="box-shadow: none !important">

        <div class="page-title card-body p-3">
            <h3>Editar Seguro</h3>
        </div>

        <section class="section pt-4">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('seguro.update', $seguro->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="identificador">Identificador</label>
                            <input type="text" class="form-control" id="identificador" name="identificador" value="{{ old('identificador', $seguro->identificador) }}" required>
                        </div>
                        <div class="form-group">
                            <label for="aseguradora">Aseguradora</label>
                            <input type="text" class="form-control" id="aseguradora" name="aseguradora" value="{{ old('aseguradora', $seguro->aseguradora) }}" required>
                        </div>
                        <div class="form-group">
                            <label for="responsable">Responsable</label>
                            <input type="text" class="form-control" id="responsable" name="responsable" value="{{ old('responsable', $seguro->responsable) }}" required>
                        </div>
                        <div class="form-group">
                            <label for="telefono">Teléfono</label>
                            <input type="text" class="form-control" id="telefono" name="telefono" value="{{ old('telefono', $seguro->telefono) }}" required>
                        </div>
                        <div class="form-group">
                            <label for="notas">Notas</label>
                            <textarea class="form-control" id="notas" name="notas">{{ old('notas', $seguro->notas) }}</textarea>
                        </div>
                        <div class="form-group">
                            <label for="precio">Precio</label>
                            <input type="number" class="form-control" id="precio" name="precio" value="{{ old('precio', $seguro->precio) }}" required>
                        </div>
                        <button type="submit" class="btn btn-primary mt-3">Actualizar</button>
                    </form>
                </div>
            </div>
        </section>

    </div>
@endsection 