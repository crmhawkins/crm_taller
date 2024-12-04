<div>
    <div class="row mb-3">
        <div class="col-md-6">
            <input type="text" class="form-control" placeholder="Buscar por nombre, código o fabricante" wire:model="search">
        </div>
        <div class="col-md-6">
            <select class="form-control" wire:model="categoria_id">
                <option value="">Todas las categorías</option>
                @foreach($categorias as $categoria)
                    <option value="{{ $categoria->id }}">{{ $categoria->nombre }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <table class="table table-striped">
        <thead>
            <tr>
                <th>Imagen</th>
                <th>Nombre</th>
                <th>Código</th>
                <th>Fabricante</th>
                <th>Marca</th>
                <th>Modelo</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($piezas as $pieza)
                <tr>
                    <td>
                        <img src="{{ asset('storage/' . $pieza->foto) }}" alt="Imagen de {{ $pieza->nombre }}" style="width: 50px; height: auto;">
                    </td>
                    <td>{{ $pieza->nombre }}</td>
                    <td>{{ $pieza->codigo }}</td>
                    <td>{{ $pieza->fabricante }}</td>
                    <td>{{ $pieza->marca }}</td>
                    <td>{{ $pieza->modelo }}</td>
                    <td>
                        <a href="{{ route('piezas.edit', $pieza) }}" class="btn btn-warning btn-sm">Editar</a>
                        <form action="{{ route('piezas.destroy', $pieza) }}" method="POST" style="display:inline;">
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
        {{ $piezas->links() }}
    </div>
</div>
