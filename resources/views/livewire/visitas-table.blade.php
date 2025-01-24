<div>
    <div class="row">
        <div class="mb-3 col-md-4">
            <label for="search">Buscar por matrícula</label>
            <input type="text" class="form-control" placeholder="Buscar por matrícula" wire:model="search">
        </div>
        <div class="mb-3 col-md-4">
            <label for="fechaInicio">Fecha de inicio</label>
            <input type="date" class="form-control" placeholder="Fecha de inicio" wire:model="fechaInicio">
        </div>
        <div class="mb-3 col-md-4">
            <label for="fechaFin">Fecha de fin</label>
            <input type="date" class="form-control" placeholder="Fecha de fin" wire:model="fechaFin">
        </div>
    </div>
    

    <table class="table ">
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
            @foreach($visitasCoche as $visita)
            {{-- {{dd($visitasCoche)}} --}}
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
        {{ $visitasCoche->links() }}
    </div>
</div>
