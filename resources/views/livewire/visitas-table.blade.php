<div>
    <div class="mb-3">
        <input type="text" class="form-control" placeholder="Buscar por coche ID o fecha de ingreso" wire:model="search">
    </div>

    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Coche</th>
                <th>Fecha Ingreso</th>
                <th>Fecha Salida</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($visitas as $visita)
                <tr class="{{ is_null($visita->fecha_salida) ? 'table-warning' : '' }}">
                    <td>{{ $visita->id }}</td>
                    <td>{{ $visita->coche ? $visita->coche->matricula : 'Sin coche' }}</td>
                    <td>{{ $visita->fecha_ingreso }}</td>
                    <td>{{ $visita->fecha_salida }}</td>
                    <td>
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
