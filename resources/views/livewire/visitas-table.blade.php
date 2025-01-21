<div>
    <div class="mb-3">
        <input type="text" class="form-control" placeholder="Buscar por coche ID o fecha de ingreso" wire:model="search">
    </div>

    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Coche ID</th>
                <th>Fecha Ingreso</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($visitas as $visita)
                <tr>
                    <td>{{ $visita->id }}</td>
                    <td>{{ $visita->coche_id }}</td>
                    <td>{{ $visita->fecha_ingreso }}</td>
                    <td>
                        <a href="{{ route('visitas.show', $visita) }}" class="btn btn-info btn-sm">Ver</a>
                        <a href="{{ route('visitas.edit', $visita) }}" class="btn btn-warning btn-sm">Editar</a>
                        <form action="{{ route('visitas.destroy', $visita) }}" method="POST" style="display:inline;">
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
        {{ $visitas->links() }}
    </div>
</div>
