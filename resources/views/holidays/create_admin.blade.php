@extends('layouts.app')

@section('title', 'Vacaciones')

@section('css')
<link rel="stylesheet" href="{{ asset('assets/vendors/simple-datatables/style.css') }}">
@endsection

@section('content')
<div class="page-heading card border-0">

    {{-- Titles --}}
    <div class="page-title card-body">
        <div class="row justify-content-between">
            <div class="col-12 col-md-6 order-md-1">
                <h3><i class="fa-solid fa-umbrella-beach"></i>Vacaciones</h3>
                <p class="text-muted">Petición de días</p>
            </div>
            <div class="col-12 col-md-6 order-md-2">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('holiday.admin.petitions') }}">Vacaciones</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Petición de días</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <section class="section pt-4">
        <div class="card">
            <div class="card-body">
                <form method="POST" action="{{ route('holiday.admin.user.store') }}" enctype="multipart/form-data" data-callback="formCallback">
                    @csrf
                    <div class="row g-3 align-items-end">
                        <div class="col-md-3">
                            <label for="admin_user_id" class="form-label">Usuario</label>
                            <select class="form-select" name="admin_user_id" id="admin_user_id">
                                @foreach ($user as $value)
                                    <option value="{{ $value->id }}">{{ $value->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label for="from_date" class="form-label">Desde</label>
                            <input type="date" name="from_date" class="form-control" id="from_date" />
                        </div>
                        <div class="col-md-3">
                            <label for="to_date" class="form-label">Hasta</label>
                            <input type="date" name="to_date" class="form-control" id="to_date" />
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Medio día</label>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="half_day" name="half_day" value="1">
                                <label class="form-check-label" for="half_day">Sí</label>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <button type="submit" class="btn btn-success">Registrar Vacaciones</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
</div>
@endsection

@section('scripts')
@include('partials.toast')
@endsection
