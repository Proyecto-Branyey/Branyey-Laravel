<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Número de teléfono de WhatsApp
    |--------------------------------------------------------------------------
    | Incluir código de país sin el signo + ni espacios
    | Ejemplo: 573213229744 (Colombia)
    */
    'phone_number' => env('WHATSAPP_PHONE', '573213229744'),

    'enabled_routes' => [
        'tienda.inicio',
        'tienda.catalogo',
        'tienda.pedidos',
    ],

    'default_message' => 'Hola, vengo de la tienda Branyey y me interesa información sobre sus productos.',
];