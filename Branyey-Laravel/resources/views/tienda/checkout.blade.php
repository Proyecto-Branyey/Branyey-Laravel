@extends('layouts.app')

@section('title', 'Finalizar Compra | Branyey')

@section('content')
<div class="container py-5">
    <div class="mb-5">
        <h1 class="fw-black text-uppercase italic display-5">Finalizar Compra</h1>
        <p class="text-muted">Estás a un paso de recibir tus prendas. Completa los datos de entrega.</p>
    </div>

    <form action="{{ route('tienda.checkout.confirm') }}" method="POST">
        @csrf
        <div class="row g-5">
            
            <div class="col-lg-7">
                <div class="card border-0 shadow-sm rounded-4 p-4 p-md-5 bg-white">
                    <h4 class="fw-bold mb-4 d-flex align-items-center">
                        <i class="bi bi-truck me-2 text-primary"></i> Información de Entrega
                    </h4>

                    <div class="row g-3">
                                                <div class="d-flex justify-content-end mb-3 gap-2">
                                                    <button type="button" id="btn-editar-datos" class="btn btn-outline-primary btn-sm">Editar datos</button>
                                                    <button type="button" id="btn-confirmar-datos" class="btn btn-success btn-sm" disabled>Confirmar datos</button>
                                                </div>
                        <div class="col-md-12">
                            <label class="form-label small fw-bold text-muted text-uppercase">Nombre Completo</label>
                            <input type="text" class="form-control form-control-lg rounded-pill bg-light border-0" 
                                value="{{ $user->nombre_completo ?: $user->username }}" readonly>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label small fw-bold text-muted text-uppercase">Teléfono de Contacto</label>
                            <input type="text" name="telefono" class="form-control form-control-lg rounded-pill @error('telefono') is-invalid @enderror" 
                                value="{{ old('telefono', $user->telefono ?? '') }}" placeholder="Ej: 300 123 4567" required disabled>
                            @error('telefono') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>


                        <div class="col-md-6">
                            <label class="form-label small fw-bold text-muted text-uppercase">Departamento</label>
                            <input type="text" name="departamento" id="departamento_checkout" list="departamentos_list_checkout" class="form-control form-control-lg rounded-pill" 
                                value="{{ old('departamento', $user->departamento_defecto ?? 'Cundinamarca') }}" required disabled>
                            <datalist id="departamentos_list_checkout"></datalist>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label small fw-bold text-muted text-uppercase">Ciudad</label>
                            <input type="text" name="ciudad" id="ciudad_checkout" list="ciudades_list_checkout" class="form-control form-control-lg rounded-pill" 
                                value="{{ old('ciudad', $user->ciudad_defecto ?? 'Bogotá') }}" required disabled>
                            <datalist id="ciudades_list_checkout"></datalist>
                            <small class="text-muted">Selecciona primero un departamento para sugerir municipios.</small>
                        </div>

                        <div class="col-12">
                            <label class="form-label small fw-bold text-muted text-uppercase">Dirección de Residencia</label>
                            <input type="text" name="direccion" class="form-control form-control-lg rounded-pill @error('direccion') is-invalid @enderror" 
                                value="{{ old('direccion', $user->direccion_defecto ?? '') }}" placeholder="Calle, Carrera, Conjunto, Apto..." required disabled>
                            @error('direccion') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-12">

                        </div>
                    </div>
                    <script>
                    document.addEventListener('DOMContentLoaded', function () {
                        const deptInput = document.getElementById('departamento_checkout');
                        const cityInput = document.getElementById('ciudad_checkout');
                        const deptList = document.getElementById('departamentos_list_checkout');
                        const cityList = document.getElementById('ciudades_list_checkout');

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
                </div>
            </div>

            <div class="col-lg-5">
                <div class="card border-0 bg-dark text-white rounded-4 p-4 shadow-lg sticky-top" style="top: 2rem;">
                    <h4 class="fw-bold mb-4 italic text-uppercase">Resumen del Pedido</h4>
                    
                    <div class="cart-items-preview mb-4" style="max-height: 300px; overflow-y: auto;">
                        @foreach($cart as $id => $item)
                        @php
                            $img = $item['image'] ?? 'default.jpg';
                            $imgUrl = Str::startsWith($img, ['http', 'storage/', '/storage/']) ? asset($img) : Storage::url($img);
                        @endphp
                        <div class="d-flex align-items-center mb-3 border-bottom border-secondary pb-3">
                            <img src="{{ $imgUrl }}" class="rounded-3 me-3" width="50" height="50" style="object-fit: cover;">
                            <div class="flex-grow-1">
                                <h6 class="mb-0 small fw-bold text-uppercase">{{ $item['name'] }}</h6>
                                <small class="text-secondary">Talla: {{ $item['talla'] }} | Cant: {{ $item['quantity'] }}</small>
                            </div>
                            <span class="fw-bold small">${{ number_format($item['price'] * $item['quantity'], 0, ',', '.') }} COP</span>
                        </div>
                        @endforeach
                    </div>

                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-secondary">Subtotal</span>
                        <span>${{ number_format($total, 0, ',', '.') }} COP</span>
                    </div>
                    <div class="d-flex justify-content-between mb-4" id="shipping-row">
                        <span class="text-secondary" id="shipping-label">Envío</span>
                        <span class="text-success fw-bold" id="shipping-value">Calculando...</span>
                    </div>

                    <hr class="border-secondary">

                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <span class="h5 mb-0 fw-bold">TOTAL A PAGAR</span>
                        <span class="h3 mb-0 fw-black italic text-warning">${{ number_format($total, 0, ',', '.') }} COP</span>
                    </div>

                    <div id="mensaje-confirma-datos" class="small text-warning mb-2">
                        <i class="bi bi-exclamation-triangle me-1"></i>Debes confirmar tus datos antes de finalizar el pedido.
                    </div>
                    <button type="submit" id="btn-confirmar-pedido" class="btn btn-warning btn-lg w-100 rounded-pill fw-black text-uppercase py-3 shadow" disabled>
                        Confirmar Pedido <i class="bi bi-chevron-right ms-2"></i>
                    </button>
                    <script>
                        document.addEventListener('DOMContentLoaded', function () {
                            const btnEditar = document.getElementById('btn-editar-datos');
                            const btnConfirmar = document.getElementById('btn-confirmar-datos');
                            const btnPedido = document.getElementById('btn-confirmar-pedido');
                            const mensaje = document.getElementById('mensaje-confirma-datos');
                            const campos = [
                                document.querySelector('input[name="telefono"]'),
                                document.querySelector('input[name="departamento"]'),
                                document.querySelector('input[name="ciudad"]'),
                                document.querySelector('input[name="direccion"]'),
                            ];
                            // Estado inicial: se puede confirmar datos o editar, pero no pedir
                            btnPedido.disabled = true;
                            btnConfirmar.disabled = false;
                            btnEditar.disabled = false;
                            // El mensaje es visible por defecto

                            btnEditar.addEventListener('click', function () {
                                campos.forEach(c => c.disabled = false);
                                btnConfirmar.disabled = false;
                                btnEditar.disabled = true;
                                btnPedido.disabled = true;
                                mensaje.classList.remove('d-none');
                            });
                            btnConfirmar.addEventListener('click', function () {
                                campos.forEach(c => c.disabled = true);
                                btnConfirmar.disabled = true;
                                btnEditar.disabled = false;
                                btnPedido.disabled = false;
                                mensaje.classList.add('d-none');

                                // Cotizar envío
                                const departamento = document.querySelector('input[name="departamento"]').value;
                                const ciudad = document.querySelector('input[name="ciudad"]').value;
                                const shippingValue = document.getElementById('shipping-value');
                                const shippingLabel = document.getElementById('shipping-label');
                                shippingValue.textContent = 'Calculando...';
                                fetch('/tienda/checkout/shipping-quote', {
                                    method: 'POST',
                                    headers: {
                                        'Content-Type': 'application/json',
                                        'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
                                    },
                                    body: JSON.stringify({ departamento, ciudad })
                                })
                                .then(r => r.json())
                                .then(data => {
                                    if(data.success && data.valor_envio !== undefined) {
                                        shippingValue.textContent = data.valor_envio === 0 ? 'GRATIS' : `$${data.valor_envio.toLocaleString('es-CO')} COP`;
                                        shippingLabel.textContent = `Envío (${ciudad})`;
                                    } else {
                                        shippingValue.textContent = 'No disponible';
                                        shippingLabel.textContent = 'Envío';
                                    }
                                })
                                .catch(() => {
                                    shippingValue.textContent = 'Error';
                                    shippingLabel.textContent = 'Envío';
                                });
                            });
                            // Si el usuario intenta enviar sin confirmar datos
                            btnPedido.form.addEventListener('submit', function(e) {
                                if(btnPedido.disabled) {
                                    e.preventDefault();
                                    mensaje.classList.remove('d-none');
                                }
                            });
                        });
                    </script>
                    </button>

                    <a href="{{ route('tienda.cart.index') }}" class="btn btn-outline-light w-100 rounded-pill fw-bold text-uppercase mt-3 py-2">
                        Volver al carrito
                    </a>
                    
                    <p class="text-center mt-3 mb-0 small text-secondary italic">
                        <i class="bi bi-shield-check me-1"></i> Compra segura protegida por Branyey
                    </p>
                </div>
            </div>

        </div>
    </form>
</div>

<style>
    .fw-black { font-weight: 900; }
    .italic { font-style: italic; }
    .btn-warning { color: #000; }
    .btn-warning:hover { background-color: #ffca2c; transform: translateY(-2px); transition: 0.3s; }
</style>
@endsection