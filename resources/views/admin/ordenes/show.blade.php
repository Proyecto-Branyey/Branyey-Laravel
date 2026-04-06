@extends('layouts.admin')
@section('title', 'Detalle de Orden')
@section('admin-content')
<div class="container py-4">
    <h1 class="h3 mb-4">Detalle de Orden</h1>
    <div class="card mb-3">
        <div class="card-body">
            <dl class="row">
                <dt class="col-sm-3">ID</dt>
                <dd class="col-sm-9">{{ $orden->id ?? '' }}</dd>
                <dt class="col-sm-3">Cliente</dt>
                <dd class="col-sm-9">{{ $orden->cliente->nombre ?? '' }}</dd>
                <dt class="col-sm-3">Fecha</dt>
                <dd class="col-sm-9">{{ $orden->fecha ?? '' }}</dd>
                <dt class="col-sm-3">Estado</dt>
                <dd class="col-sm-9">{{ $orden->estado ?? '' }}</dd>
            </dl>
        </div>
    </div>
    <a href="{{ route('admin.ordenes.index') }}" class="btn btn-secondary">Volver al listado</a>
</div>
@endsection
