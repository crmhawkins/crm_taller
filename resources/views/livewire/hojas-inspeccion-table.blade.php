<div>
    <table class="table mt-3">
        <thead>
            <tr>
                <th>Fecha</th>
                <th>Matrícula</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($hojasInspeccion as $hoja)
            <tr>
                <td>{{ $hoja->fecha }}</td>
                <td>{{ $hoja->matricula }}</td>
                <td>
                    <a href="{{ route('hojas_inspeccion.edit', [$hoja->coche_id, $hoja->id]) }}" class="btn btn-sm btn-warning">Editar</a>
                    <!-- Aquí puedes añadir más acciones como eliminar -->
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
