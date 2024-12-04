<div>
    <div class="mb-3">
        <input type="text" class="form-control" placeholder="Buscar..." wire:model.debounce.300ms="search">
    </div>

    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Identificador</th>
                <th>Fecha</th>
                <th>Póliza</th>
                <th>Cliente</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($siniestros as $siniestro)
                <tr>
                    <td>{{ $siniestro->id }}</td>
                    <td>{{ $siniestro->identificador }}</td>
                    <td>{{ $siniestro->fecha }}</td>
                    <td>{{ $siniestro->poliza }}</td>
                    <td>{{ $siniestro->cliente->nombre }}</td>
                    <td>
                        <a href="{{ route('siniestro.edit', $siniestro->id) }}" class="btn btn-sm btn-warning">Editar</a>
                        <form action="{{ route('siniestro.destroy', $siniestro->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger">Eliminar</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="mt-3">
        {{ $siniestros->links() }}
    </div>
</div> 