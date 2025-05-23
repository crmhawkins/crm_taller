@extends('layouts.app')

@section('titulo', 'Editar Baja')

@section('css')
<link rel="stylesheet" href="{{asset('assets/vendors/choices.js/choices.min.css')}}" />

@endsection

@section('content')
    <div class="page-heading card" style="box-shadow: none !important" >
        <div class="page-title card-body">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>Editar Baja</h3>
                    <p class="text-subtitle text-muted">Formulario para editar una baja</p>
                </div>

                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{route('bajas.index')}}">Bajas</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Editar baja</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>

        <section class="section my-4">
            <div class="row">
                <div class="col-sm-12 col-md-9">
                    <div class="card">
                        <div class="card-body">
                            <form id="actualizar" action="{{route('bajas.update', $baja->id)}}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="bloque-formulario">
                                    <div class="row">
                                        <div class="col-sm-12 col-md-6">
                                            {{-- Gestor model:User --}}
                                            <div class="form-group mb-3">
                                                <label class="mb-2 text-left">Usuario</label>
                                                <select class="choices form-select w-100 @error('admin_user_id') is-invalid @enderror" name="admin_user_id" id="admin_user_id">
                                                        <option value="">Seleccione </option>
                                                        @foreach ( $usuarios as $user )
                                                            <option {{(old('admin_user_id',$baja->admin_user_id) == $user->id ? 'selected' : '' )}}  value="{{$user->id}}">{{$user->name}}</option>
                                                        @endforeach
                                                </select>
                                                @error('admin_user_id')
                                                    <p class="invalid-feedback d-block" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </p>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-md-6">
                                            {{-- inicio --}}
                                            <div class="form-group mb-3">
                                                <label class="mb-2 text-left" for="inicio">Fecha de inicio:</label>
                                                <input type="date" class="form-control @error('inicio') is-invalid @enderror" id="inicio" value="{{ old('inicio',$baja->inicio) }}" name="inicio">
                                                @error('inicio')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12 col-md-6">
                                            {{-- archivos --}}
                                            <div class="form-group mb-3">
                                                <label class="mb-2 text-left" for="archivos[]">Archivos:</label>
                                                <input type="file" class="form-control" id="archivos[]" value="{{ old('archivos[]') }}" name="archivos[]" multiple>

                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-md-6">
                                            {{-- fin --}}
                                            <div class="form-group mb-3">
                                                <label class="mb-2 text-left" for="fin">Fecha de fin :</label>
                                                <input type="date" class="form-control @error('fin') is-invalid @enderror" id="fin" value="{{ old('fin',$baja->fin) }}" name="fin">
                                                @error('fin')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12">
                                            {{-- Observaciones --}}
                                            <div class="form-group">
                                                <label for="observacion">Observaciones:</label>
                                                <textarea class="form-control @error('observacion') is-invalid @enderror" id="observacion" name="observacion">{{ old('observacion',$baja->observacion) }}</textarea>
                                                @error('observacion')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="card my-3">
                        <div class="card-body">
                            <div class="col-12">
                                @if(count($archivos) > 0)
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>Nombre del Archivo</th>
                                                <th>Acción</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($archivos as $archivo)
                                                <tr>
                                                    <td>{{ basename($archivo) }}</td>
                                                    <td>
                                                        <a href="{{ asset('storage/' . $archivo) }}" class="btn btn-primary" download>Descargar</a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                @else
                                    <p>No hay archivos subidos para esta baja.</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12 col-md-3">
                    <div class="card">
                        <div class="card-body">
                            <div class="card-title">
                                Acciones
                                <hr>
                            </div>
                            <a href="" id="botonActualizar" class="btn btn-success btn-block mb-3">Actualizar</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </section>
    </div>

@endsection

@section('scripts')
<script src="{{asset('assets/vendors/choices.js/choices.min.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.8.7/chosen.jquery.min.js" integrity="sha512-rMGGF4wg1R73ehtnxXBt5mbUfN9JUJwbk21KMlnLZDJh7BkPmeovBuddZCENJddHYYMkCh9hPFnPmS9sspki8g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
     $('#botonActualizar').click(function(e){
            e.preventDefault(); // Esto previene que el enlace navegue a otra página.
            $('#actualizar').submit(); // Esto envía el formulario.
        });
</script>
@endsection

