@extends('layouts.app')

@section('content')
<style>
    .inactive-sort {
        color: #0F1739;
        text-decoration: none;
    }
    .active-sort {
        color: #757191;
    }
</style>
<div class="container-fluid">
    <h2 class="mb-3">Sub Cuenta Contable</h2>
    <a href="{{ route('subCuentasContables.create') }}" class="btn bg-color-quinto">Añadir sub cuenta contable</a>
    <hr class="mb-5">
    <div class="row justify-content-center">
        <div class="col-md-12">
            @if (session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
            @endif
            <div class="mb-3">
                <form action="{{ route('subCuentasContables.index') }}" method="GET">
                    <div class="input-group">
                        <input type="text" name="search" class="form-control" placeholder="Buscar..." value="{{ request('search') }}">
                        <select name="subGrupo" class="form-control">
                            <option value="">Selecciona Cuenta Contable</option>
                            @foreach ($subCuentas as $subCuenta)
                                <option value="{{ $subCuenta->id }}" {{ request('subGrupo') == $subCuenta->id ? 'selected' : '' }}>{{ $subCuenta->numero }} - {{ $subCuenta->nombre }}</option>
                            @endforeach
                        </select>
                        <button type="submit" class="btn btn-primary">Filtrar</button>
                    </div>
                </form>
            </div>
            <table class="table table-striped table-hover">
              <thead>
                <tr>
                    <th scope="col">
                        <a href="{{ route('subCuentasContables.index', array_merge(request()->query(), ['sort' => 'cuenta_id', 'order' => request('order', 'asc') == 'asc' ? 'desc' : 'asc'])) }}">
                            Cuenta
                            @if (request('sort') == 'cuenta_id')
                                <i class="fa {{ request('order', 'asc') == 'asc' ? 'fa-arrow-up' : 'fa-arrow-down' }}"></i>
                            @endif
                        </a>
                    </th>
                    <th scope="col">
                        <a href="{{ route('subCuentasContables.index', array_merge(request()->query(), ['sort' => 'numero', 'order' => request('order', 'asc') == 'asc' ? 'desc' : 'asc'])) }}">
                            Número
                            @if (request('sort') == 'numero')
                                <i class="fa {{ request('order', 'asc') == 'asc' ? 'fa-arrow-up' : 'fa-arrow-down' }}"></i>
                            @endif
                        </a>
                    </th>
                    <th scope="col">
                        <a href="{{ route('subCuentasContables.index', array_merge(request()->query(), ['sort' => 'nombre', 'order' => request('order', 'asc') == 'asc' ? 'desc' : 'asc'])) }}">
                            Nombre
                            @if (request('sort') == 'nombre')
                                <i class="fa {{ request('order', 'asc') == 'asc' ? 'fa-arrow-up' : 'fa-arrow-down' }}"></i>
                            @endif
                        </a>
                    </th>
                    <th scope="col">
                        <a href="{{ route('subCuentasContables.index', array_merge(request()->query(), ['sort' => 'descripcion', 'order' => request('order', 'asc') == 'asc' ? 'desc' : 'asc'])) }}">
                            Descripción
                            @if (request('sort') == 'descripcion')
                                <i class="fa {{ request('order', 'asc') == 'asc' ? 'fa-arrow-up' : 'fa-arrow-down' }}"></i>
                            @endif
                        </a>
                    </th>
                    <th scope="col">Acciones/Editar</th>
                    <th scope="col">Eliminar</th>
                </tr>
              </thead>
              <tbody>
                  @foreach ($response as $item)
                      <tr>
                          <td>{{ $item->cuenta->numero }} - {{ $item->cuenta->nombre }}</td>
                          <td>{{ $item->numero }}</td>
                          <td>{{ $item->nombre }}</td>
                          <td>{{ $item->descripcion }}</td>
                          <td>
                              <a href="{{ route('subCuentasContables.edit', $item->id) }}" class="btn btn-secundario">Editar</a>
                          </td>
                          <td>
                              <form action="{{ route('subCuentasContables.destroy', $item->id) }}" method="POST">
                                  @csrf
                                  <button type="button" class="btn btn-danger delete-btn">Eliminar</button>
                              </form>
                          </td>
                      </tr>
                  @endforeach
              </tbody>
            </table>
            {{ $response->appends(request()->query())->links() }}
        </div>
    </div>
</div>

@include('sweetalert::alert')

@section('scripts')
<script>
  document.addEventListener('DOMContentLoaded', function () {
      // Verificar si SweetAlert2 está definido
      if (typeof Swal === 'undefined') {
          console.error('SweetAlert2 is not loaded');
          return;
      }

      // Botones de eliminar
      const deleteButtons = document.querySelectorAll('.delete-btn');
      deleteButtons.forEach(button => {
          button.addEventListener('click', function (event) {
              event.preventDefault();
              const form = this.closest('form');
              Swal.fire({
                  title: '¿Estás seguro?',
                  text: "¡No podrás revertir esto!",
                  icon: 'warning',
                  showCancelButton: true,
                  confirmButtonColor: '#3085d6',
                  cancelButtonColor: '#d33',
                  confirmButtonText: 'Sí, eliminar!',
                  cancelButtonText: 'Cancelar'
              }).then((result) => {
                  if (result.isConfirmed) {
                      form.submit();
                  }
              });
          });
      });
  });
</script>
@endsection
@endsection
