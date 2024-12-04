<div>
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Tipo</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($tipos as $tipo)
                <tr>
                    <td>{{ $tipo->id }}</td>
                    <td>{{ $tipo->tipo }}</td>
                    <td>
                        <a href="{{ route('tipo-siniestro.edit', $tipo->id) }}" class="btn btn-sm btn-warning">Editar</a>
                        <form action="{{ route('tipo-siniestro.destroy', $tipo->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger">Eliminar</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div> 