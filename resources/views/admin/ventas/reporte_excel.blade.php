<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Cliente</th>
            <th>Fecha</th>
            <th>Total</th>
            <th>Estado</th>
        </tr>
    </thead>
    <tbody>
        @foreach($ventas as $venta)
            <tr>
                <td>{{ $venta->id }}</td>
                <td>{{ $venta->usuario->nombre_completo ?? $venta->usuario->name ?? '-' }}</td>
                <td>{{ $venta->created_at->format('Y-m-d H:i') }}</td>
                <td>${{ number_format($venta->total, 0, ',', '.') }}</td>
                <td>{{ ucfirst($venta->estado) }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
