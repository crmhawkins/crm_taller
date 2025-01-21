<div>
    <div class="row mb-3">
        <div class="col-md-3">
            <select wire:model="campo" class="form-select">
                <option value="estado">Estado</option>
                <option value="cliente">Cliente</option>
                <option value="coche">Coche</option>
            </select>
        </div>
        <div class="col-md-3">
            <input type="date" 
                   class="form-control" 
                   placeholder="Fecha de Inicio" 
                   wire:model="fechaInicio">
        </div>
        <div class="col-md-3">
            <input type="date" 
                   class="form-control" 
                   placeholder="Fecha de Fin" 
                   wire:model="fechaFin">
        </div>
        <div class="col-md-3">
            <input type="text" 
                   class="form-control" 
                   placeholder="Buscar..." 
                   wire:model.debounce.300ms="search">
        </div>
    </div>

    <table class="table">
        <thead>
            <tr>
                <th>Fecha de Inicio</th>
                <th>Fecha de Fin</th>
                <th>Estado</th>
                <th>Cliente</th>
                <th>Coche</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($reservas as $reserva)
                <tr>
                    <td>{{ $reserva->fecha_inicio }}</td>
                    <td>{{ $reserva->fecha_fin }}</td>
                    <td>{{ $reserva->estado }}</td>
                    <td>{{ $reserva->cliente->name }} {{ $reserva->cliente->lastname }}</td>
                    <td>{{ $reserva->cocheSustitucion->matricula }}</td>
                    <td>
                        <a href="{{ route('reservas-coche.edit', $reserva->id) }}" 
                           class="btn btn-sm btn-primary">
                            Editar
                        </a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <h2 class="mt-5 mb-3" style="color: font-size: 20px; font-weight: bold;">Coches Disponibles</h2>
    <div class="row mb-3">
        <div class="col-md-3">
            <input type="text" 
                   class="form-control" 
                   placeholder="Buscar coche..." 
                   wire:model.debounce.300ms="searchCoches">
        </div>
    </div>
    <table class="table">
        <thead>
            <tr>
                <th>Matrícula</th>
                <th>Marca</th>
                <th>Modelo</th>
            </tr>
        </thead>
        <tbody>
            @foreach($cochesDisponibles as $coche)
                <tr>
                    <td>{{ $coche->matricula }}</td>
                    <td>{{ $coche->marca }}</td>
                    <td>{{ $coche->modelo }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="mt-3">
        {{ $cochesDisponibles->links() }}
    </div>
</div>