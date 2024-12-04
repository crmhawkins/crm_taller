@extends('layouts.app')

@section('titulo', 'Editar Pieza')

@section('content')

<div class="page-heading card" style="box-shadow: none !important">

    {{-- Titulos --}}
    <div class="page-title card-body p-3">
        <div class="row justify-content-between">
            <div class="col-12 col-md-4 order-md-1 order-first">
                <h3><i class="bi bi-gear"></i> Editar Pieza</h3>
            </div>
        </div>
    </div>

    <section class="section pt-4">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('piezas.update', $pieza->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="form-group mb-3">
                        <label for="foto">Foto:</label>
                        @if($pieza->foto)
                            <div class="mb-2">
                                <img src="{{ asset('storage/' . $pieza->foto) }}" alt="Imagen de {{ $pieza->nombre }}" style="width: 100px; height: auto;">
                            </div>
                        @endif
                        <input type="file" name="foto" class="form-control">
                    </div>
                    <div class="form-group mb-3">
                        <label for="nombre">Nombre:</label>
                        <input type="text" name="nombre" class="form-control" value="{{ $pieza->nombre }}" required>
                    </div>
                    <div class="form-group mb-3">
                        <label for="codigo">Código:</label>
                        <input type="text" name="codigo" class="form-control" value="{{ $pieza->codigo }}" required>
                    </div>
                    <div class="form-group mb-3">
                        <label for="fabricante">Fabricante:</label>
                        <input type="text" name="fabricante" class="form-control" value="{{ $pieza->fabricante }}">
                    </div>
                    <div class="form-group mb-3">
                        <label for="marca">Marca:</label>
                        <input type="text" name="marca" class="form-control" value="{{ $pieza->marca }}">
                    </div>
                    <div class="form-group mb-3">
                        <label for="modelo">Modelo:</label>
                        <input type="text" name="modelo" class="form-control" value="{{ $pieza->modelo }}">
                    </div>
                    <div class="form-group mb-3">
                        <label for="descripcion">Descripción:</label>
                        <textarea name="descripcion" class="form-control">{{ $pieza->descripcion }}</textarea>
                    </div>
                    <div class="form-group mb-3">
                        <label for="nota">Nota:</label>
                        <textarea name="nota" class="form-control">{{ $pieza->nota }}</textarea>
                    </div>
                    <div class="form-group mb-3">
                        <label for="numero_serie">Número de Serie:</label>
                        <input type="text" name="numero_serie" class="form-control" value="{{ $pieza->numero_serie }}">
                    </div>
                    <div class="form-group mb-3">
                        <label for="proveedor_id">Proveedor:</label>
                        <select name="proveedor_id" class="form-control">
                            <option value="">Seleccione un proveedor</option>
                            @foreach($proveedores as $proveedor)
                                <option value="{{ $proveedor->id }}" {{ $pieza->proveedor_id == $proveedor->id ? 'selected' : '' }}>
                                    {{ $proveedor->name }} {{ $proveedor->cif }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group mb-3">
                        <label for="categoria_id">Categoría:</label>
                        <select name="categoria_id" class="form-control">
                            <option value="">Seleccione una categoría</option>
                            @foreach($categorias as $categoria)
                                <option value="{{ $categoria->id }}" {{ $pieza->categoria_id == $categoria->id ? 'selected' : '' }}>
                                    {{ $categoria->nombre }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Actualizar</button>
                </form>
            </div>
        </div>
    </section>

</div>
@endsection
