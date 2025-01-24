<div>
    <div class="mb-3">
        <input type="text" class="form-control" placeholder="Buscar por matrícula o modelo" wire:model="search">
    </div>

    <table class="table table-striped">
        <thead>
            <tr>
                <th>Matrícula</th>
                <th>VIN</th>
                <th>Seguro</th>
                <th>Marca</th>
                <th>Modelo</th>
                <th>Año</th>
                <th>Kilometraje</th>
                <th>Color</th>
                <th>Cliente</th>
                <th>Foto</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($coches as $coche)
                <tr>
                    <td>{{ $coche->matricula }}</td>
                    <td>{{ $coche->vin }}</td>
                    <td>{{ $coche->seguro }}</td>
                    <td>{{ $coche->marca }}</td>
                    <td>{{ $coche->modelo }}</td>
                    <td>{{ $coche->anio }}</td>
                    <td>{{ $coche->kilometraje }}</td>
                    <td>{{ $coche->color }}</td>
                    @if ($coche->cliente_id)
                        <td><a href="{{ route('clientes.edit', $coche->cliente->id) }}">{{ $coche->cliente->name }} {{ $coche->cliente->lastname }} </a></td>
                    @else
                        <td>Sin cliente</td>
                    @endif
                    <td>
                        @if ($coche->foto)
                            <img src="{{ asset('storage/' . $coche->foto) }}" alt="Foto de {{ $coche->modelo }}" class="img-thumbnail" style="width: 100px; cursor: pointer;" data-toggle="modal" data-target="#fotoModal{{ $coche->id }}">
                        @else
                            Sin foto
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('coches.edit', $coche) }}" class="btn btn-warning btn-sm">Editar</a>
                        <a href="{{ route('hojas_inspeccion.index', $coche) }}" class="btn btn-secondary btn-sm">Hojas Inspección</a>
                        <a href="{{ route('visitas.index', ['coche_id' => $coche->id]) }}" class="btn btn-info btn-sm">Visitas</a>

                        <form action="{{ route('coches.destroy', $coche) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Eliminar</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="d-flex justify-content-center">
        {{ $coches->links() }}
    </div>
</div>

<!-- Modals for each car -->
@foreach($coches as $coche)
    @if ($coche->foto)
        <div class="modal fade" id="fotoModal{{ $coche->id }}" tabindex="-1" role="dialog" aria-labelledby="fotoModalLabel{{ $coche->id }}" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="fotoModalLabel{{ $coche->id }}">Foto de {{ $coche->modelo }}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <img src="{{ asset('storage/' . $coche->foto) }}" alt="Foto de {{ $coche->modelo }}" class="img-fluid">
                    </div>
                </div>
            </div>
        </div>
    @endif
@endforeach

@section('scripts')
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
@endsection
