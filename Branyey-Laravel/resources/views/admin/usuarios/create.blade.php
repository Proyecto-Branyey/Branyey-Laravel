@extends('layouts.admin')

@section('admin-content')
<div class="container py-4">
    <h1>Nuevo Usuario</h1>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.usuarios.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="nombre_completo" class="form-label">Nombre completo</label>
            <input type="text" name="nombre_completo" id="nombre_completo" class="form-control" value="{{ old('nombre_completo') }}">
        </div>
        <div class="mb-3">
            <label for="telefono" class="form-label">Teléfono</label>
            <input type="text" name="telefono" id="telefono" class="form-control" value="{{ old('telefono') }}">
        </div>
        <div class="mb-3">
            <label for="direccion_defecto" class="form-label">Dirección</label>
            <input type="text" name="direccion_defecto" id="direccion_defecto" class="form-control" value="{{ old('direccion_defecto') }}">
        </div>
        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="departamento_defecto" class="form-label">Departamento</label>
                <input type="text" name="departamento_defecto" id="departamento_defecto" list="departamentos_list" class="form-control" value="{{ old('departamento_defecto') }}">
                <datalist id="departamentos_list"></datalist>
            </div>
            <div class="col-md-6 mb-3">
                <label for="ciudad_defecto" class="form-label">Ciudad</label>
                <input type="text" name="ciudad_defecto" id="ciudad_defecto" list="ciudades_list" class="form-control" value="{{ old('ciudad_defecto') }}">
                <datalist id="ciudades_list"></datalist>
                <small class="text-muted">Selecciona primero un departamento para sugerir municipios.</small>
            </div>
        </div>
        <div class="mb-3">
            <label for="username" class="form-label">Usuario</label>
            <input type="text" name="username" id="username" class="form-control" value="{{ old('username') }}" required>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" name="email" id="email" class="form-control" value="{{ old('email') }}" required>
        </div>
        <div class="mb-3">
            <label for="rol_id" class="form-label">Rol</label>
            <select name="rol_id" id="rol_id" class="form-control" required>
                <option value="">Seleccione un rol</option>
                @foreach($roles as $rol)
                    <option value="{{ $rol->id }}" {{ old('rol_id') == $rol->id ? 'selected' : '' }}>{{ $rol->nombre }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Contraseña</label>
            <input type="password" name="password" id="password" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="password_confirmation" class="form-label">Confirmar Contraseña</label>
            <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-success">Guardar</button>
        <a href="{{ route('admin.usuarios.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const deptInput = document.getElementById('departamento_defecto');
    const cityInput = document.getElementById('ciudad_defecto');
    const deptList = document.getElementById('departamentos_list');
    const cityList = document.getElementById('ciudades_list');

    if (!deptInput || !cityInput || !deptList || !cityList) {
        return;
    }

    const API_BASE = 'https://api-colombia.com/api/v1';
    let departments = [];

    const normalize = (value) => (value || '').toString().trim().toLowerCase();

    const renderCityOptions = (cities) => {
        cityList.innerHTML = '';
        cities.forEach((city) => {
            const option = document.createElement('option');
            option.value = city.name;
            cityList.appendChild(option);
        });
    };

    const loadCitiesByDepartmentName = async () => {
        const deptName = normalize(deptInput.value);
        const selectedDepartment = departments.find((dept) => normalize(dept.name) === deptName);

        cityList.innerHTML = '';

        if (!selectedDepartment) {
            return;
        }

        try {
            const response = await fetch(`${API_BASE}/Department/${selectedDepartment.id}/cities`);
            if (!response.ok) {
                return;
            }
            const cities = await response.json();
            renderCityOptions(Array.isArray(cities) ? cities : []);
        } catch (error) {
            // Si la API falla, el usuario puede escribir ciudad manualmente.
        }
    };

    const loadDepartments = async () => {
        try {
            const response = await fetch(`${API_BASE}/Department`);
            if (!response.ok) {
                return;
            }

            const data = await response.json();
            departments = Array.isArray(data)
                ? data.slice().sort((a, b) => a.name.localeCompare(b.name, 'es'))
                : [];

            deptList.innerHTML = '';
            departments.forEach((dept) => {
                const option = document.createElement('option');
                option.value = dept.name;
                deptList.appendChild(option);
            });

            if (deptInput.value) {
                loadCitiesByDepartmentName();
            }
        } catch (error) {
            // Si la API falla, el usuario puede escribir departamento manualmente.
        }
    };

    deptInput.addEventListener('change', () => {
        cityInput.value = '';
        loadCitiesByDepartmentName();
    });

    deptInput.addEventListener('blur', loadCitiesByDepartmentName);

    loadDepartments();
});
</script>
@endsection
