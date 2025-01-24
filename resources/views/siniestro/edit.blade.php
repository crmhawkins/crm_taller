@extends('layouts.app')

@section('titulo', 'Editar Parte de Trabajo')

@section('content')

    <style>
        .gallery {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            background-color: #f8f9fa;
            padding: 15px;
            border-radius: 8px;
        }
        .gallery-item {
            flex: 1 1 calc(50% - 10px);
            box-sizing: border-box;
            margin-bottom: 10px;
            overflow: hidden;
            position: relative;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .gallery-item img {
            width: 400px;
            max-height: 200px;
            object-fit: cover;
            border-radius: 5px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s, box-shadow 0.3s;
        }
        .gallery-item img:hover {
            transform: scale(1.1);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
        }
        .gallery-item::after {
            content: '\f002';
            font-family: FontAwesome;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            color: white;
            font-size: 24px;
            opacity: 0;
            transition: opacity 0.3s;
        }
        .gallery-item:hover::after {
            opacity: 1;
        }
        .delete-button {
            position: absolute;
            top: 5px;
            right: 5px;
            background-color: rgba(255, 0, 0, 0.7);
            color: white;
            border: none;
            border-radius: 50%;
            width: 30px;
            height: 30px;
            display: flex;
            justify-content: center;
            align-items: center;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        .delete-button:hover {
            background-color: rgba(255, 0, 0, 1);
        }
        .select2-container--default .select2-selection--single {
            height: 50px !important;
            display: block !important;
            flex-direction: row !important;
            justify-content: center !important;
            align-items: center !important;
        }

        .select2-selection--single > span {
            display: flex !important;
            flex-direction: row !important;
            justify-content: center !important;
            align-items: center !important;
            margin: 0 auto !important;
            height: 50px !important;
        }
    </style>


    <link href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/css/lightbox.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/js/lightbox.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />

    <div class="page-heading card" style="box-shadow: none !important">
        <div class="page-title card-body p-3">
            <h3>Editar Parte de Trabajo</h3>
        </div>

        <section class="section pt-4">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('siniestro.update', $siniestro->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group mb-3">
                                    <label for="identificador">Identificador</label>
                                    <input type="text" class="form-control" id="identificador" name="identificador" value="{{ old('identificador', $siniestro->identificador) }}">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group mb-3">
                                    <label for="poliza">Póliza</label>
                                    <input type="text" class="form-control" id="poliza" name="poliza" value="{{ old('poliza', $siniestro->poliza) }}">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group mb-3">
                                    <label for="coche_id">Coche</label>
                                    <br>
                                    <select class="form-control select2" id="coche_id" name="coche_id">
                                        @foreach($coches as $coche)
                                            <option value="{{ $coche->id }}" {{ $siniestro->coche_id == $coche->id ? 'selected' : '' }}>{{ $coche->matricula }} {{ $coche->marca }} {{ $coche->modelo }} - {{ $coche->color }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group mb-3">
                                    <label for="cliente_id">Cliente</label>
                                    <select class="form-control select2" id="cliente_id" name="cliente_id">
                                        @foreach($clientes as $cliente)
                                            <option value="{{ $cliente->id }}" {{ $siniestro->cliente_id == $cliente->id ? 'selected' : '' }}>{{ $cliente->name }} {{ $cliente->surname }} - {{ $cliente->cif }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group mb-3">
                                    <label for="seguro_id">Seguro</label>
                                    <select class="form-control select2" id="seguro_id" name="seguro_id">
                                        <option value="">Selecciona un seguro</option>
                                        @foreach($seguros as $seguro)
                                            <option value="{{ $seguro->id }}" {{ $siniestro->seguro_id == $seguro->id ? 'selected' : '' }}>{{ $seguro->identificador }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group mb-3">
                                    <label for="coste_reparacion">Coste de Reparación</label>
                                    <input type="number" class="form-control" id="coste_reparacion" name="coste_reparacion" value="{{ old('coste_reparacion', $siniestro->coste_reparacion) }}">
                                </div>
                            </div>
                            <div class="col-md-3">
                                    <div class="form-group mb-3">
                                    <label for="monto_cliente">Coste Cliente</label>
                                    <input type="number" class="form-control" id="monto_cliente" name="monto_cliente" value="{{ old('monto_cliente', $siniestro->monto_cliente) }}">
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group mb-3">
                                    <label for="monto_aseguradora">Coste Aseguradora</label>
                                    <input type="number" class="form-control" id="monto_aseguradora" name="monto_aseguradora" value="{{ old('monto_aseguradora', $siniestro->monto_aseguradora) }}">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group mb-3">
                                    <label for="prioridad">Prioridad</label>
                                    <input type="text" class="form-control" id="prioridad" name="prioridad" value="{{ old('prioridad', $siniestro->prioridad) }}">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group mb-3">
                                    <label for="fecha">Fecha</label>
                                    <input type="date" class="form-control" id="fecha" name="fecha" value="{{ old('fecha', $siniestro->fecha) }}">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group mb-3">
                                    <label for="inicio_reparacion">Inicio de Reparación</label>
                                    <input type="date" class="form-control" id="inicio_reparacion" name="inicio_reparacion" value="{{ old('inicio_reparacion', $siniestro->inicio_reparacion) }}">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group mb-3">
                                    <label for="fin_reparacion">Fin de Reparación</label>
                                    <input type="date" class="form-control" id="fin_reparacion" name="fin_reparacion" value="{{ old('fin_reparacion', $siniestro->fin_reparacion) }}">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group mb-3">
                                    <label for="tipo_siniestro_id">Tipo de Trabajo</label>
                                    <select class="form-control" id="tipo_siniestro_id" name="tipo_siniestro_id">
                                        <option value="">Selecciona un tipo</option>
                                        @foreach($tiposSiniestro as $tipo)
                                            <option value="{{ $tipo->id }}" {{ $siniestro->tipo_siniestro_id == $tipo->id ? 'selected' : '' }}>{{ $tipo->tipo }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group mb-3">
                                    <label for="estado_siniestro_id">Estado de Trabajo</label>
                                    <select class="form-control" id="estado_siniestro_id" name="estado_siniestro_id">
                                        <option value="">Selecciona un estado</option>
                                        @foreach($estadosSiniestro as $estado)
                                            <option value="{{ $estado->id }}" {{ $siniestro->estado_siniestro_id == $estado->id ? 'selected' : '' }}>{{ $estado->estado }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group mb-3">
                                    <label for="peritaje">Peritaje</label>
                                    <select class="form-control" id="peritaje" name="peritaje">
                                        <option value="1" {{ $siniestro->peritaje == 1 ? 'selected' : '' }}>Si</option>
                                        <option value="0" {{ $siniestro->peritaje == 0 ? 'selected' : '' }}>No</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">

                                <div class="form-group mb-3">
                                    <label for="peritaje_externo">Peritaje Externo</label>
                                    <select class="form-control" id="peritaje_externo" name="peritaje_externo">
                                        <option value="1" {{ $siniestro->peritaje_externo == 1 ? 'selected' : '' }}>Si</option>
                                        <option value="0" {{ $siniestro->peritaje_externo == 0 ? 'selected' : '' }}>No</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group mb-3">
                                    <label for="descripcion">Descripción</label>
                                    <textarea class="form-control" id="descripcion" name="descripcion">{{ old('descripcion', $siniestro->descripcion) }}</textarea>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group mb-3">
                                    <label for="comentarios">Comentarios</label>
                                    <textarea class="form-control" id="comentarios" name="comentarios">{{ old('comentarios', $siniestro->comentarios) }}</textarea>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group mb-3">
                                    <label for="daños">Daños</label>
                                    <textarea class="form-control" id="daños" name="daños">{{ old('daños', $siniestro->daños) }}</textarea>
                                </div>
                            </div>

                            <div class="col-md-3">
                                

                                <div class="form-group mb-3">
                                    <label for="imagenes">Imagenes</label>
                                    <input type="file" class="form-control" id="imagenes" name="imagenes[]" multiple>
                                </div>
                            </div>
                            <div class="col-md-3">
                                
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary mt-3">Actualizar</button>
                    </form>
                </div>
            </div>
        </section>
        <div class="form-group mb-3 mt-3">
            <label class="mb-3" style="font-weight: bold; font-size: 1.2rem;">Imágenes del trabajo</label>
            <div class="gallery">
                @foreach($siniestro->getMedia('imagenes') as $media)
                    <div class="gallery-item">
                        <a href="{{ $media->getFullUrl() }}" data-lightbox="siniestro-gallery" data-title="Imagen del siniestro">
                            <img src="{{ $media->getFullUrl() }}" alt="Imagen del siniestro">
                        </a>
                        <form action="{{ route('media.destroy', $media->id) }}" method="POST" style="position: absolute; top: 0; right: 0;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="delete-button">&times;</button>
                        </form>
                    </div>
                @endforeach
            </div>
        </div>

    </div>
@endsection 

@section('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
<script>
    $(document).ready(function() {
        $('.select2').select2();
    });
</script>
@endsection
