<?php

test('registration screen can be rendered', function () {
    $response = $this->get('/register');

    $response->assertStatus(200);
});

test('new users can register', function () {
    $response = $this->post('/register', [
        'name' => 'Test User',
        'nombre_completo' => 'Test User',
        'username' => 'testuser',
        'email' => 'test@example.com',
        'telefono' => '3000000000',
        'direccion_defecto' => 'Calle 1 # 2-3',
        'ciudad_defecto' => 'Bogota',
        'departamento_defecto' => 'Cundinamarca',
        'password' => 'password',
        'password_confirmation' => 'password',
    ]);

    $response->assertRedirect(route('dashboard', absolute: false));

    $this->assertDatabaseHas('usuarios', [
        'email' => 'test@example.com',
    ]);
});
