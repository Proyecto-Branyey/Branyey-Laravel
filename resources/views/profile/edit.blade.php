@extends('layouts.app')

@section('title', 'Mi Perfil')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center g-4">
        <div class="col-lg-10">
            <div class="row g-4">
                <div class="col-md-6">
                    <div class="bg-white rounded-4 shadow-lg p-4 h-100 border-0" style="border-top: 6px solid #667eea;">
                        <div class="d-flex align-items-center mb-3">
                            <div class="bg-primary bg-gradient rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 54px; height: 54px;">
                                <i class="bi bi-person-circle text-white fs-2"></i>
                            </div>
                            <div>
                                <h2 class="fw-black mb-0" style="letter-spacing:-1px; color:#0a0e27;">Mi Perfil</h2>
                                <div class="small text-muted">Gestiona tu información personal y credenciales</div>
                            </div>
                        </div>
                        <hr class="mb-4 mt-2">
                        @include('profile.partials.update-profile-information-form', ['user' => $user])
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="bg-white rounded-4 shadow-sm p-4 h-100 border-0" style="border-top: 6px solid #764ba2;">
                        <div class="d-flex align-items-center mb-3">
                            <i class="bi bi-shield-lock text-secondary fs-3 me-2"></i>
                            <h4 class="fw-bold mb-0" style="color:#764ba2;">Cambiar Contraseña</h4>
                        </div>
                        <hr class="mb-3 mt-2">
                        @include('profile.partials.update-password-form')
                    </div>
                </div>
            </div>
            <div class="row justify-content-center mt-4">
                <div class="col-md-8">
                    <div class="bg-white rounded-4 shadow-sm p-4 border-0 text-center" style="border-top: 4px solid #e3342f;">
                        <div class="d-flex flex-column align-items-center mb-3">
                            <i class="bi bi-trash3 text-danger fs-4 mb-2"></i>
                            <h5 class="fw-bold mb-0 text-danger">Eliminar Cuenta</h5>
                        </div>
                        <hr class="mb-3 mt-2">
                        <div class="alert alert-warning mb-3">
                            <strong>Te recomendamos descargar tu información antes de eliminar tu cuenta.</strong>
                        </div>
                        <a href="{{ route('profile.datos.pdf') }}" class="btn btn-outline-primary mb-3">
                            <i class="bi bi-download me-1"></i> Descargar mis datos en PDF
                        </a>
                        @include('profile.partials.delete-user-form')
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
