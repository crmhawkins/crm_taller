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
                    <td>{{ $coche->cliente->name }} {{ $coche->cliente->lastname }} </td>
                    <td>
                        <a href="{{ route('coches.edit', $coche) }}" class="btn btn-warning btn-sm">Editar</a>
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
