<div>
    <div class="row mb-3">
        <div class="col-md-3">
            <select wire:model="campo" class="form-select">
                <option value="matricula">Matrícula</option>
                <option value="marca">Marca</option>
                <option value="modelo">Modelo</option>
            </select>
        </div>
        <div class="col-md-9">
            <input type="text" 
                   class="form-control" 
                   placeholder="Buscar..." 
                   wire:model.debounce.300ms="search">
        </div>
    </div>

    <table class="table table-striped">
        <thead>
            <tr>
                <th>Matrícula</th>
                <th>Marca</th>
                <th>Modelo</th>
                <th>Kilometraje</th>
                <th>Color</th>
                <th>Año</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($coches as $coche)
                <tr>
                    <td>{{ $coche->matricula }}</td>
                    <td>{{ $coche->marca }}</td>
                    <td>{{ $coche->modelo }}</td>
                    <td>{{ $coche->kilometraje }}</td>
                    <td>{{ $coche->color }}</td>
                    <td>{{ $coche->anio }}</td>
                    <td>
                        <a href="{{ route('coches-sustitucion.edit', $coche->id) }}" class="btn btn-sm btn-warning">Editar</a>
                        <form action="{{ route('coches-sustitucion.destroy', $coche->id) }}" method="POST" style="display:inline;">
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
        {{ $coches->links() }}
    </div>
</div>