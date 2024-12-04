<div>
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($estados as $estado)
                <tr>
                    <td>{{ $estado->id }}</td>
                    <td>{{ $estado->estado }}</td>
                    <td>
                        <a href="{{ route('estado-siniestro.edit', $estado->id) }}" class="btn btn-sm btn-warning">Editar</a>
                        <form action="{{ route('estado-siniestro.destroy', $estado->id) }}" method="POST" style="display:inline;">
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
