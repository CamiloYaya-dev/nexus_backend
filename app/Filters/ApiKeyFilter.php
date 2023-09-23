<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class ApiKeyFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        // En la cabecera de la peticion debe ir X-API-Key
        $apiKey = $request->getHeaderLine('X-API-Key');

        if (empty($apiKey) || $apiKey !== 'tuB20yGzdLhPQkcI9WxNvcAfJqOD5w3m') {
            // Si la llave no es válida, responde con el error
            return service('response')->setStatusCode(401)->setJSON(['error' => 'Acceso no autorizado']);
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // No es necesario realizar ninguna acción después de la ejecución del controlador
        // Se deja esta funcion por que es la estructura que esta esperando codeigniter, eliminarla genera error.
    }
}
