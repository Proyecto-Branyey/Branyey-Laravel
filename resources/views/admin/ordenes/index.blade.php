@extends('layouts.admin')
@section('title', 'Órdenes')
@section('admin-content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="h3">Listado de Órdenes</h1>
        <a href="{{ route('admin.ordenes.create') }}" class="btn btn-primary">Nueva Orden</a>
    </div>
    <div class="card">
        <div class="card-body p-0">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Cliente</th>
                        <th>Fecha</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    {{-- Aquí van las órdenes --}}
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
