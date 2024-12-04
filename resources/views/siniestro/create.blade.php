@extends('layouts.app')

@section('titulo', 'Crear Siniestro')

@section('content')

    <div class="page-heading card" style="box-shadow: none !important">

        <div class="page-title card-body p-3">
            <h3>Crear Siniestro</h3>
        </div>

        <section class="section pt-4">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('siniestro.store') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="identificador">Identificador</label>
                                    <input type="text" class="form-control" id="identificador" name="identificador">
                                </div>
                                <div class="form-group mb-3">
                                    <label for="coche_id">Coche</label>
                                    <select class="form-control" id="coche_id" name="coche_id">
                                        @foreach($coches as $coche)
                                            <option value="{{ $coche->id }}">{{ $coche->matricula }} - {{$coche->marca}}  {{ $coche->modelo }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="cliente_id">Cliente</label>
                                    <select class="form-control" id="cliente_id" name="cliente_id">
                                        @foreach($clientes as $cliente)
                                            <option value="{{ $cliente->id }}">{{ $cliente->name }} {{ $cliente->surname }} - {{ $cliente->cif }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="seguro_id">Seguro</label>
                                    <select class="form-control" id="seguro_id" name="seguro_id">
                                        @foreach($seguros as $seguro)
                                            <option value="{{ $seguro->id }}">{{ $seguro->identificador }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="fecha">Fecha</label>
                                    <input type="date" class="form-control" id="fecha" name="fecha">
                                </div>
                                <div class="form-group mb-3">
                                    <label for="inicio_reparacion">Inicio de Reparación</label>
                                    <input type="date" class="form-control" id="inicio_reparacion" name="inicio_reparacion">
                                </div>
                                <div class="form-group mb-3">
                                    <label for="descripcion">Descripción</label>
                                    <textarea class="form-control" id="descripcion" name="descripcion"></textarea>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="daños">Daños</label>
                                    <textarea class="form-control" id="daños" name="daños"></textarea>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="tipo_siniestro_id">Tipo de Siniestro</label>
                                    <select class="form-control" id="tipo_siniestro_id" name="tipo_siniestro_id">
                                        @foreach($tiposSiniestro as $tipo)
                                            <option value="{{ $tipo->id }}">{{ $tipo->tipo }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group mb-3">
                                </div>
                                
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="poliza">Póliza</label>
                                    <input type="text" class="form-control" id="poliza" name="poliza">
                                </div>
                                <div class="form-group mb-3">
                                    <label for="coste_reparacion">Coste de Reparación</label>
                                    <input type="number" class="form-control" id="coste_reparacion" name="coste_reparacion">
                                </div>
                                <div class="form-group mb-3">
                                    <label for="monto_cliente">Monto Cliente</label>
                                    <input type="number" class="form-control" id="monto_cliente" name="monto_cliente">
                                </div>
                                <div class="form-group mb-3">
                                    <label for="monto_aseguradora">Monto Aseguradora</label>
                                    <input type="number" class="form-control" id="monto_aseguradora" name="monto_aseguradora">
                                </div>
                                <div class="form-group mb-3">
                                    <label for="prioridad">Prioridad</label>
                                    <input type="text" class="form-control" id="prioridad" name="prioridad">
                                </div>
                                <div class="form-group mb-3">
                                    <label for="fin_reparacion">Fin de Reparación</label>
                                    <input type="date" class="form-control" id="fin_reparacion" name="fin_reparacion">
                                </div>
                                <div class="form-group mb-3">
                                    <label for="comentarios">Comentarios</label>
                                    <textarea class="form-control" id="comentarios" name="comentarios"></textarea>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="estado_siniestro_id">Estado de Siniestro</label>
                                    <select class="form-control" id="estado_siniestro_id" name="estado_siniestro_id">
                                        @foreach($estadosSiniestro as $estado)
                                            <option value="{{ $estado->id }}">{{ $estado->estado }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="peritaje">Peritaje</label>
                                        <select class="form-control" id="peritaje" name="peritaje">
                                            <option value="1">Si</option>
                                            <option value="0" selected>No</option>
                                        </select>
                                    </div>
                                <div class="form-group mb-3">
                                    <label for="peritaje_externo">Peritaje Externo</label>
                                    <select class="form-control" id="peritaje_externo" name="peritaje_externo">
                                        <option value="1">Si</option>
                                        <option value="0" selected>No</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary mt-3">Crear</button>
                    </form>
                </div>
            </div>
        </section>

    </div>
@endsection 