@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Editar Visita</h1>
    <form action="{{ route('visitas.update', $visitaCoche) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="coche_id">Coche ID</label>
            <input type="text" name="coche_id" class="form-control" value="{{ $visitaCoche->coche_id }}" required>
        </div>
        <div class="form-group">
            <label for="fecha_ingreso">Fecha Ingreso</label>
            <input type="date" name="fecha_ingreso" class="form-control" value="{{ $visitaCoche->fecha_ingreso }}">
        </div>
        <!-- Añade más campos según sea necesario -->
        <button type="submit" class="btn btn-primary">Actualizar</button>
    </form>
</div>
@endsection 