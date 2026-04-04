@extends('layouts.app')

@section('title', 'Registro Completo - Branyey')

@section('content')
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm border-0">
                <div class="card-body p-4 p-md-5">
                    <div class="text-center mb-4">
                        <h2 class="fw-bold text-dark">CREAR CUENTA</h2>
                        <p class="text-muted small">Completa tus datos para agilizar tus envíos y compras.</p>
                    </div>

                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <h5 class="text-secondary border-bottom pb-2 mb-3">Información de Cuenta</h5>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label small fw-bold">NOMBRE COMPLETO</label>
                                <input type="text" name="nombre_completo" class="form-control @error('nombre_completo') is-invalid @enderror" value="{{ old('nombre_completo') }}" required autofocus>
                                @error('nombre_completo') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label small fw-bold">NOMBRE DE USUARIO</label>
                                <input type="text" name="username" class="form-control @error('username') is-invalid @enderror" value="{{ old('username') }}" required>
                                @error('username') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-12 mb-3">
                                <label class="form-label small fw-bold">CORREO ELECTRÓNICO</label>
                                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" required>
                                @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <h5 class="text-secondary border-bottom pb-2 mb-3 mt-3">Datos de Envío y Contacto</h5>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label small fw-bold">TELÉFONO / WHATSAPP</label>
                                <input type="text" name="telefono" class="form-control @error('telefono') is-invalid @enderror" value="{{ old('telefono') }}" required placeholder="300 000 0000">
                                @error('telefono') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label small fw-bold">DIRECCIÓN</label>
                                <input type="text" name="direccion_defecto" class="form-control @error('direccion_defecto') is-invalid @enderror" value="{{ old('direccion_defecto') }}" required placeholder="Calle, Carrera, Apto...">
                                @error('direccion_defecto') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label small fw-bold">CIUDAD</label>
                                <input type="text" name="ciudad_defecto" class="form-control @error('ciudad_defecto') is-invalid @enderror" value="{{ old('ciudad_defecto') }}" required>
                                @error('ciudad_defecto') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label small fw-bold">DEPARTAMENTO</label>
                                <input type="text" name="departamento_defecto" class="form-control @error('departamento_defecto') is-invalid @enderror" value="{{ old('departamento_defecto') }}" required>
                                @error('departamento_defecto') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <h5 class="text-secondary border-bottom pb-2 mb-3 mt-3">Seguridad</h5>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label small fw-bold">CONTRASEÑA</label>
                                <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" required>
                                @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label small fw-bold">CONFIRMAR CONTRASEÑA</label>
                                <input type="password" name="password_confirmation" class="form-control" required>
                            </div>
                        </div>

                        <div class="d-grid mt-4">
                            <button type="submit" class="btn btn-dark py-3 fw-bold">REGISTRARME AHORA</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection