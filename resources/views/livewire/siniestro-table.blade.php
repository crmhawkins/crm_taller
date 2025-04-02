<div>
    <div class="mb-3 row">
        <div class="col-md-3">
            <select wire:model="campo" class="form-select">
                <option value="identificador">Identificador</option>
                <option value="seguro">Seguro</option>
                <option value="cliente">Cliente</option>
                <option value="matricula">Matrícula</option>
                <option value="prioridad">Prioridad</option>
            </select>
        </div>
        <div class="col-md-9">
            <input type="text"
                   class="form-control"
                   placeholder="Buscar..."
                   wire:model.debounce.300ms="search">
        </div>
        <!-- Nuevos filtros de fecha -->
        <div class="col-md-3 mt-3">
            <input type="date"
                   class="form-control"
                   placeholder="Fecha inicio"
                   wire:model="fechaInicio">
        </div>
        <div class="col-md-3 mt-3">
            <input type="date"
                   class="form-control"
                   placeholder="Fecha fin"
                   wire:model="fechaFin">
        </div>
    </div>

    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Identificador</th>
                <th>Fecha</th>
                <th>Seguro</th>
                <th>Cliente</th>
                <th>Coche</th>
                <th>Prioridad</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($siniestros as $siniestro)
                <tr>
                    <td>{{ $siniestro->id }}</td>
                    <td>{{ $siniestro->identificador }}</td>
                    <td>{{ $siniestro->fecha }}</td>
                    @if($siniestro->seguro)
                        <td><a href="{{ route('seguro.edit', $siniestro->seguro->id) }}" class="btn btn-link">
                            {{ $siniestro->seguro->aseguradora }}
                        </a></td>
                    @else
                        <td></td>
                    @endif
                    <td>
                        @if (isset($siniestro->coche->id))
                            <a href="{{ route('clientes.edit', $siniestro->cliente->id) }}" class="btn btn-link">
                                {{ $siniestro->cliente->name }} {{ $siniestro->cliente->surname }}
                            </a>

                        @endif

                    </td>
                    <td>
                        @if (isset($siniestro->coche->id))
                            <a href="{{ route('coches.edit', $siniestro->coche->id) }}" class="btn btn-link" style="">
                                {{ $siniestro->coche->matricula }}
                            </a>

                        @endif
                    </td>
                    <td>{{$siniestro->prioridad}}</td>

                    <td>

                        <a href="{{ route('siniestro.edit', $siniestro->id) }}" class="btn btn-sm btn-warning">Editar</a>
                        <form action="{{ route('siniestro.destroy', $siniestro->id) }}" method="POST" style="display:inline;">
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
        {{ $siniestros->links() }}
    </div>
</div>