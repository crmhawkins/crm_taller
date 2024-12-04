<div>
    <div class="mb-3">
        <input type="text" class="form-control" placeholder="Buscar..." wire:model.debounce.300ms="search">
    </div>

    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Identificador</th>
                <th>Aseguradora</th>
                <th>Responsable</th>
                <th>Teléfono</th>
                <th>Precio</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($seguros as $seguro)
                <tr>
                    <td>{{ $seguro->id }}</td>
                    <td>{{ $seguro->identificador }}</td>
                    <td>{{ $seguro->aseguradora }}</td>
                    <td>{{ $seguro->responsable }}</td>
                    <td>{{ $seguro->telefono }}</td>
                    <td>{{ $seguro->precio }}</td>
                    <td>
                        <a href="{{ route('seguro.edit', $seguro->id) }}" class="btn btn-sm btn-warning">Editar</a>
                        <form action="{{ route('seguro.destroy', $seguro->id) }}" method="POST" style="display:inline;">
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
        {{ $seguros->links() }}
    </div>
</div> 