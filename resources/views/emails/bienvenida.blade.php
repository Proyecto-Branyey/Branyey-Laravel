<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bienvenido a Branyey</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f4f4f4; margin: 0; padding: 0; color: #222; }
        .wrapper { max-width: 600px; margin: 30px auto; background: #fff; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 20px rgba(0,0,0,.08); }
        .header { background: #111; padding: 40px 40px 30px; text-align: center; }
        .header h1 { color: #fff; margin: 0 0 6px; font-size: 32px; letter-spacing: 3px; text-transform: uppercase; font-style: italic; }
        .header p { color: #aaa; margin: 0; font-size: 14px; letter-spacing: 1px; }
        .hero { background: #ffca2c; padding: 28px 40px; text-align: center; }
        .hero h2 { margin: 0; font-size: 24px; font-weight: 900; text-transform: uppercase; color: #111; letter-spacing: 1px; }
        .body { padding: 36px 40px; }
        .body p { font-size: 15px; line-height: 1.7; color: #555; }
        .body h3 { font-size: 17px; color: #111; margin-bottom: 14px; }
        .benefits { list-style: none; padding: 0; margin: 0 0 28px; }
        .benefits li { padding: 10px 0; border-bottom: 1px solid #f0f0f0; font-size: 15px; color: #444; display: flex; align-items: flex-start; gap: 10px; }
        .benefits li:last-child { border-bottom: none; }
        .benefits .icon { font-size: 20px; flex-shrink: 0; }
        .cta-btn { display: block; width: fit-content; margin: 0 auto 28px; background: #111; color: #fff; text-decoration: none; padding: 14px 36px; border-radius: 50px; font-weight: bold; font-size: 15px; text-transform: uppercase; letter-spacing: 1px; }
        .divider { border: none; border-top: 1px solid #eee; margin: 24px 0; }
        .footer { background: #111; padding: 24px 40px; text-align: center; }
        .footer p { color: #888; font-size: 12px; margin: 0; line-height: 1.8; }
    </style>
</head>
<body>
<div class="wrapper">

    <div class="header">
        <h1>Branyey</h1>
        <p>Moda que te define</p>
    </div>

    <div class="hero">
        <h2>¡Ya eres parte de la familia! 🎉</h2>
    </div>

    <div class="body">
        <p>Hola, <strong>{{ $user->nombre_completo ?: $user->username }}</strong>. Gracias por unirte a Branyey. Tu cuenta ha sido creada con éxito y ya puedes explorar todo nuestro catálogo de ropa.</p>

        <h3>¿Qué puedes hacer ahora?</h3>
        <ul class="benefits">
            <li>
                <span class="icon">👗</span>
                <span>Explorar toda la colección de prendas para niño, dama y adulto.</span>
            </li>
            <li>
                <span class="icon">🛒</span>
                <span>Agregar productos al carrito y hacer tu primer pedido fácilmente.</span>
            </li>
            <li>
                <span class="icon">📦</span>
                <span>Hacer seguimiento de tus pedidos desde "Mis Pedidos".</span>
            </li>
            <li>
                <span class="icon">🧾</span>
                <span>Descargar la factura en PDF de cada compra.</span>
            </li>
        </ul>

        <a href="{{ url('/tienda') }}" class="cta-btn">Ver el Catálogo →</a>

        <hr class="divider">

        <p style="font-size:13px; color:#888;">
            Registrado con: <strong>{{ $user->email }}</strong><br>
            Tipo de cuenta: <strong>{{ ucfirst($user->rol->nombre ?? 'minorista') }}</strong>
        </p>
    </div>

    <div class="footer">
        <p>Este correo fue enviado automáticamente por <strong style="color:#fff;">Branyey</strong>.<br>
        &copy; {{ date('Y') }} Branyey — Todos los derechos reservados.</p>
    </div>

</div>
</body>
</html>
