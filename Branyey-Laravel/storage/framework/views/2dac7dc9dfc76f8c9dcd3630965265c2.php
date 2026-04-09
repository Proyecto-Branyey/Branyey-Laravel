<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Factura de Venta #<?php echo e($venta->id); ?> - Branyey</title>
    <style>
        /* Reset */
        * { margin: 0; padding: 0; box-sizing: border-box; }
        
        body {
            font-family: 'Times New Roman', 'Georgia', serif;
            font-size: 11pt;
            margin: 2cm;
            color: #000;
            line-height: 1.3;
        }
        
        /* Tipografía seria */
        h1, h2, h3, .serif { font-family: 'Times New Roman', serif; }
        
        /* Header formal */
        .header {
            text-align: center;
            margin-bottom: 30px;
        }
        
        .header .title {
            font-size: 18pt;
            font-weight: bold;
            letter-spacing: 4px;
            margin-bottom: 5px;
        }
        
        .header .subtitle {
            font-size: 10pt;
            border-top: 1px solid #000;
            border-bottom: 1px solid #000;
            display: inline-block;
            padding: 4px 20px;
            margin-top: 5px;
        }
        
        /* Identificación del documento */
        .doc-id {
            text-align: right;
            font-size: 9pt;
            margin-bottom: 25px;
            font-family: monospace;
        }
        
        /* Secciones */
        .section {
            margin-bottom: 20px;
        }
        
        .section-title {
            font-size: 11pt;
            font-weight: bold;
            text-transform: uppercase;
            background: #e8e8e8;
            padding: 4px 8px;
            margin-bottom: 12px;
        }
        
        /* Tabla de datos */
        .info-block {
            margin-bottom: 15px;
        }
        
        .info-row {
            display: flex;
            padding: 4px 0;
            border-bottom: 0.5px dotted #ccc;
        }
        
        .info-label {
            width: 160px;
            font-weight: 600;
        }
        
        .info-value {
            flex: 1;
        }
        
        /* Tabla de productos */
        .items-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 10pt;
            margin-top: 10px;
        }
        
        .items-table th {
            border: 1px solid #000;
            padding: 8px 6px;
            background: #e8e8e8;
            font-weight: bold;
            text-align: center;
        }
        
        .items-table td {
            border: 1px solid #000;
            padding: 6px;
        }
        
        .items-table td:first-child,
        .items-table td:nth-child(2),
        .items-table td:nth-child(4) {
            text-align: center;
        }
        
        .items-table td:nth-child(3) {
            text-align: right;
        }
        
        /* Totales */
        .totals-table {
            width: 300px;
            margin-top: 15px;
            margin-left: auto;
            border-collapse: collapse;
        }
        
        .totals-table td {
            padding: 6px 8px;
            border-bottom: 0.5px dotted #ccc;
        }
        
        .totals-table td:first-child {
            font-weight: 600;
        }
        
        .totals-table td:last-child {
            text-align: right;
        }
        
        .grand-total {
            font-size: 12pt;
            font-weight: bold;
            border-top: 1px solid #000;
        }
        
        /* Footer */
        .footer {
            margin-top: 35px;
            padding-top: 10px;
            border-top: 1px solid #ccc;
            font-size: 8pt;
            text-align: center;
        }
        
        .text-right { text-align: right; }
        .text-center { text-align: center; }
    </style>
</head>
<body>
    <?php
        // Subtotal real de productos (sumatoria de detalle de venta)
        $subtotalProductos = (float) ($venta->detallesVenta->sum(function ($detalle) {
            return ((float) $detalle->precio_cobrado) * ((int) $detalle->cantidad);
        }) ?: 0);

        // El total guardado en venta ya incluye envío; lo derivamos para no duplicarlo.
        $totalFinal = (float) ($venta->total ?? 0);
        $envio = max($totalFinal - $subtotalProductos, 0);
    ?>
    
    <div class="doc-id">
        Folio: INV-<?php echo e(str_pad($venta->id, 8, '0', STR_PAD_LEFT)); ?> | Emisión: <?php echo e(now()->format('Y-m-d H:i')); ?>

    </div>

    <div class="header">
        <div class="title">BRANYEY</div>
        <div class="subtitle">FACTURA DE VENTA</div>
    </div>

    
    <div class="section">
        <div class="section-title">DATOS DEL CLIENTE</div>
        <div class="info-block">
            <div class="info-row"><span class="info-label">Identificador:</span><span class="info-value">CLI-<?php echo e(str_pad($venta->usuario->id ?? 0, 6, '0', STR_PAD_LEFT)); ?></span></div>
            <div class="info-row"><span class="info-label">Nombre legal:</span><span class="info-value"><?php echo e($venta->usuario->nombre_completo ?? $venta->usuario->name ?? 'No especificado'); ?></span></div>
            <div class="info-row"><span class="info-label">Correo electrónico:</span><span class="info-value"><?php echo e($venta->usuario->email ?? 'N/A'); ?></span></div>
            <div class="info-row"><span class="info-label">Línea de contacto:</span><span class="info-value"><?php echo e($venta->usuario->telefono ?? 'No especificado'); ?></span></div>
        </div>
    </div>

    
    <div class="section">
        <div class="section-title">INFORMACIÓN DE LA VENTA</div>
        <div class="info-block">
            <div class="info-row"><span class="info-label">N° Transacción:</span><span class="info-value">TRX-<?php echo e(str_pad($venta->id, 7, '0', STR_PAD_LEFT)); ?></span></div>
            <div class="info-row"><span class="info-label">Fecha de emisión:</span><span class="info-value"><?php echo e($venta->created_at->format('d/m/Y H:i:s')); ?></span></div>
            <div class="info-row"><span class="info-label">Estado actual:</span><span class="info-value"><?php echo e(ucfirst(str_replace('_', ' ', $venta->estado))); ?></span></div>
        </div>
    </div>

    
    <?php if($venta->detallesOrden): ?>
    <div class="section">
        <div class="section-title">DOMICILIO DE ENVÍO</div>
        <div class="info-block">
            <div class="info-row"><span class="info-label">Dirección:</span><span class="info-value"><?php echo e($venta->detallesOrden->direccion_envio ?? 'No registrada'); ?></span></div>
            <div class="info-row"><span class="info-label">Ubicación geográfica:</span><span class="info-value"><?php echo e($venta->detallesOrden->ciudad ?? 'No registrada'); ?>, <?php echo e($venta->detallesOrden->departamento ?? 'No registrado'); ?></span></div>
        </div>
    </div>
    <?php endif; ?>

    
    <div class="section">
        <div class="section-title">DETALLE DE PRODUCTOS</div>
        
        <?php if($venta->detallesVenta && $venta->detallesVenta->count() > 0): ?>
            <table class="items-table">
                <thead>
                    <tr>
                        <th style="width: 40px;">#</th>
                        <th>Producto</th>
                        <th style="width: 100px;">Cantidad</th>
                        <th style="width: 130px;">Precio Unitario</th>
                        <th style="width: 150px;">Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $venta->detallesVenta; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $detalle): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td class="text-center"><?php echo e($index + 1); ?></td>
                            <td><?php echo e($detalle->variante && $detalle->variante->producto ? ($detalle->variante->producto->nombre_comercial ?? $detalle->variante->producto->nombre) : 'Producto no disponible'); ?></td>
                            <td class="text-center"><?php echo e($detalle->cantidad); ?></td>
                            <td class="text-right">$<?php echo e(number_format($detalle->precio_cobrado, 0, ',', '.')); ?> COP</td>
                            <td class="text-right">$<?php echo e(number_format($detalle->cantidad * $detalle->precio_cobrado, 0, ',', '.')); ?> COP</td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
            
            
            <table class="totals-table">
                <tr>
                    <td>Subtotal productos</td>
                    <td>$<?php echo e(number_format($subtotalProductos, 0, ',', '.')); ?> COP</td>
                </tr>
                <tr>
                    <td>Envío</td>
                    <td>
                        <?php if($envio === 0): ?> 
                            GRATIS 
                        <?php else: ?> 
                            $<?php echo e(number_format($envio, 0, ',', '.')); ?> COP
                        <?php endif; ?>
                    </td>
                </tr>
                <tr class="grand-total">
                    <td>TOTAL</td>
                    <td>$<?php echo e(number_format($totalFinal, 0, ',', '.')); ?> COP</td>
                </tr>
            </table>
        <?php else: ?>
            <p>No se encontraron productos asociados a esta venta.</p>
        <?php endif; ?>
    </div>

    
    <div class="footer">
        <p>Documento generado automáticamente desde el sistema Branyey.</p>
        <p>Para cualquier inconsistencia, comunicarse con soporte@branyey.com</p>
        <p style="margin-top: 8px;">Este documento es una representación fiel de la transacción realizada.</p>
    </div>
</body>
</html><?php /**PATH C:\Users\USER\Documents\Branyeygit\Branyey-Laravel\resources\views/admin/ventas/factura.blade.php ENDPATH**/ ?>