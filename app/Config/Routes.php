<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
// Rutas validadas del api con el apikey
$routes->group('api', ['filter' => 'apiKey'], function ($routes) {
    $routes->get('user', 'UserController::index'); // Obtener todos los usuarios
    $routes->get('user/(:num)', 'UserController::show/$1'); // Obtener usuario por ID
    $routes->post('user', 'UserController::create'); // Crear un usuario
    $routes->put('user/(:num)', 'UserController::update/$1'); // Editar usuario por ID
    $routes->delete('user/(:num)', 'UserController::delete/$1'); // Eliminar usuario por ID
});

