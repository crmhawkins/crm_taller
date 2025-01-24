@extends('layouts.app')

@section('titulo', 'Añadir Pieza')

@section('content')

<div class="page-heading card" style="box-shadow: none !important">

    {{-- Titulos --}}
    <div class="page-title card-body p-3">
        <div class="row justify-content-between">
            <div class="col-12 col-md-4 order-md-1 order-first">
                <h3><i class="bi bi-gear"></i> Añadir Pieza</h3>
            </div>
        </div>
    </div>

    <section class="section pt-4">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('piezas.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group mb-3">
                                <label for="foto">Foto:</label>
                                <input type="file" name="foto" class="form-control">
                            </div>
                        </div>
                    <div class="col-md-3">
                        <div class="form-group mb-3">
                            <label for="nombre">Nombre:</label>
                            <input type="text" name="nombre" class="form-control" required>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group mb-3">
                            <label for="codigo">Código:</label>
                            <input type="text" name="codigo" class="form-control" required>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group mb-3">
                            <label for="numero_serie">Número de Serie:</label>
                            <input type="text" name="numero_serie" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group mb-3">
                            <label for="fabricante">Fabricante:</label>
                            <input type="text" name="fabricante" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group mb-3">
                            <label for="marca">Marca:</label>
                            <input type="text" name="marca" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group mb-3">
                            <label for="modelo">Modelo:</label>
                            <input type="text" name="modelo" class="form-control">
                        </div>
                    </div>
                    {{-- <div class="col-md-3">
                        <div class="form-group mb-3">
                            <label for="proveedor_id">Proveedor:</label>
                            <select name="proveedor_id" class="form-control">
                            <option value="">Seleccione un proveedor</option>
                            @foreach($proveedores as $proveedor)
                                <option value="{{ $proveedor->id }}">{{ $proveedor->name }}</option>
                            @endforeach
                            </select>
                        </div>
                    </div> --}}
                    <div class="col-md-3">
                        <div class="form-group mb-3">
                            <label for="categoria_id">Categoría:</label>
                            <select name="categoria_id" class="form-control">
                            <option value="">Seleccione una categoría</option>
                            @foreach($categorias as $categoria)
                                <option value="{{ $categoria->id }}">{{ $categoria->nombre }}</option>
                            @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group mb-3">
                            <label for="descripcion">Descripción:</label>
                            <textarea name="descripcion" class="form-control"></textarea>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group mb-3">
                            <label for="nota">Nota:</label>
                            <textarea name="nota" class="form-control"></textarea>
                        </div>
                    </div>
                    
                   
                    
                </div>
                <div class="col-md-3">
                    <button type="submit" class="btn btn-primary">Guardar</button>
                </div>
                </form>
            </div>
        </div>
    </section>

</div>
@endsection
