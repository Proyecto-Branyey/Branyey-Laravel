@extends('layouts.app') 

@section('title', 'Iniciar Sesión')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card shadow-sm border-0">
                <div class="card-body p-5">
                    <h2 class="text-center mb-4 fw-bold">INICIAR SESIÓN</h2>
                    
                    @if (session('status'))
                        <div class="alert alert-success mb-4">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="mb-3">
                            <label for="login" class="form-label text-secondary small fw-bold">CORREO O USUARIO</label>
                            <input id="login" type="text" class="form-control @error('login') is-invalid @enderror" 
                                   name="login" value="{{ old('login') }}" required autofocus autocomplete="username">
                            @error('login')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label text-secondary small fw-bold">CONTRASEÑA</label>
                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" 
                                   name="password" required autocomplete="current-password">
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3 form-check">
                            <input type="checkbox" class="form-check-input" id="remember_me" name="remember">
                            <label class="form-check-label small text-muted" for="remember_me">Recordar sesión</label>
                        </div>

                        <div class="d-grid gap-2 mt-4">
                            <button type="submit" class="btn btn-dark py-2 fw-bold">
                                ENTRAR
                            </button>
                        </div>

                        <div class="text-center mt-3">
                            @if (Route::has('password.request'))
                                <a class="text-decoration-none small text-muted" href="{{ route('password.request') }}">
                                    ¿Olvidaste tu contraseña?
                                </a>
                            @endif
                        </div>
                    </form>
                </div>
            </div>
            <p class="text-center mt-4 small text-muted">
                ¿No tienes cuenta? <a href="{{ route('register') }}" class="text-dark fw-bold">Regístrate aquí</a>
            </p>
        </div>
    </div>
</div>
@endsection