<html>
<head>
	<meta charset="utf-8">
	<title>Mis datos de usuario</title>
	<style>
		body { font-family: Arial, sans-serif; }
		h2 { color: #333; }
		.info { margin-bottom: 10px; }
		.label { font-weight: bold; }
	</style>
</head>
<body>
	<h2>Datos de mi cuenta</h2>
	<p>Te recomendamos descargar tu información antes de eliminar tu cuenta.</p>
	<div class="info"><span class="label">Usuario:</span> {{ $user->username }}</div>
	<div class="info"><span class="label">Correo electrónico:</span> {{ $user->email }}</div>
	<div class="info"><span class="label">Nombre completo:</span> {{ $user->nombre_completo }}</div>
	<div class="info"><span class="label">Teléfono:</span> {{ $user->telefono }}</div>
	<div class="info"><span class="label">Dirección de envío:</span> {{ $user->direccion_defecto }}</div>
	<div class="info"><span class="label">Ciudad:</span> {{ $user->ciudad_defecto }}</div>
	<div class="info"><span class="label">Departamento:</span> {{ $user->departamento_defecto }}</div>
</body>
<hr>
<h2>Historial de compras</h2>
@php $ventas = $user->ventas; @endphp
@if($ventas->isEmpty())
	<p>No tienes compras registradas.</p>
@else
	<table width="100%" border="1" cellspacing="0" cellpadding="4" style="font-size:13px; margin-top:10px;">
		<thead>
			<tr style="background:#f2f2f2;">
				<th>ID</th>
				<th>Fecha</th>
				<th>Total</th>
				<th>Estado</th>
			</tr>
		</thead>
		<tbody>
		@foreach($ventas as $venta)
			<tr>
				<td>{{ $venta->id }}</td>
				<td>{{ $venta->created_at->format('Y-m-d') }}</td>
				<td>${{ number_format($venta->total, 2) }}</td>
				<td>{{ ucfirst($venta->estado) }}</td>
			</tr>
		@endforeach
		</tbody>
	</table>
@endif
</body>
</html>
