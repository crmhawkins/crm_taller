@extends('layouts.app')

@section('titulo', 'Crear Seguro')

@section('content')

    <div class="page-heading card" style="box-shadow: none !important">

        <div class="page-title card-body p-3">
            <h3>Crear Seguro</h3>
        </div>

        <section class="section pt-4">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('seguro.store') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="form-group col-md-4 mb-2">
                                <label for="identificador">Identificador</label>
                                <input type="text" class="form-control" id="identificador" name="identificador" required>
                            </div>
                            <div class="form-group col-md-4 mb-2">
                                <label for="aseguradora">Aseguradora</label>
                                <input type="text" class="form-control" id="aseguradora" name="aseguradora" required>
                            </div>
                            <div class="form-group col-md-4 mb-2">
                                <label for="precio">Precio</label>
                                <input type="number" class="form-control" id="precio" name="precio" required>
                            </div>
                            <div class="form-group col-md-4 mb-2">
                                <label for="responsable">Responsable</label>
                                <input type="text" class="form-control" id="responsable" name="responsable" >
                            </div>
                            <div class="form-group col-md-4 mb-2">
                                <label for="telefono">Teléfono</label>
                                <input type="text" class="form-control" id="telefono" name="telefono" >
                            </div>
                            
                            <div class="form-group col-md-4 mb-2">
                                <label for="notas">Notas</label>
                                <textarea class="form-control" id="notas" name="notas"></textarea>
                            </div>
                            
                        </div>
                        
                        <button type="submit" class="btn btn-primary mt-3">Crear</button>
                    </form>
                </div>
            </div>
        </section>

    </div>
@endsection 