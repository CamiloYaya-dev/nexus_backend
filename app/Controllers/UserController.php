<?php

namespace App\Controllers;

use App\DAO\UserDAO;
use CodeIgniter\API\ResponseTrait;
use CodeIgniter\HTTP\Response;

class UserController extends BaseController
{
    use ResponseTrait;

    protected $userDAO;
    protected $validation;

    public function __construct()
    {
        $this->userDAO = new UserDAO();
        $this->validation = \Config\Services::validation(); // Carga el servicio de validación  
    }

    public function index()
    {
        try {
            $users = $this->userDAO->getAllUsers();
    
            $response = [
                'status' => 'success',
                'message' => 'Usuarios obtenidos',
                'data'   => $users,
            ];
    
            return $this->respond($response, Response::HTTP_OK)->setContentType('application/json');
        } catch (\CodeIgniter\Exceptions\PageNotFoundException $e) {
            // Maneja la excepción de "No se encontraron usuarios" aquí
            $response = [
                'status'  => 'error',
                'message' => $e->getMessage(),
            ];
    
            return $this->respond($response, Response::HTTP_NOT_FOUND)->setContentType('application/json');
        }
    }

    public function show($id)
    {
        try {
            $user = $this->userDAO->getUserByID($id);
    
            $response = [
                'status' => 'success',
                'message' => 'Usuarios obtenido',
                'data'   => $user,
            ];
    
            return $this->respond($response, Response::HTTP_OK)->setContentType('application/json');
        } catch (\CodeIgniter\Exceptions\PageNotFoundException $e) {
            // Maneja la excepción de "Usuario no encontrado para el ID:" aquí
            $response = [
                'status'  => 'error',
                'message' => $e->getMessage(),
            ];
    
            return $this->respond($response, Response::HTTP_NOT_FOUND)->setContentType('application/json');
        }
    }

    public function create()
    {
        $data = $this->request->getJSON();

        // Aplica las reglas de validación definidas en UserModel
        if (!$this->validate($this->userDAO->getValidationRules(), $this->userDAO->getValidationMessages())) {
            // Si la validación falla, retorna los errores
            return $this->respond(['status' => 'error', 'errors' => $this->validation->getErrors()], Response::HTTP_BAD_REQUEST);
        }

        try {
            $result = $this->userDAO->createUser($data);

            $response = [
                'status'  => 'success',
                'message' => 'Usuario creado',
                'id'    => $result, // Aquí puedes devolver el ID del registro insertado
            ];

            return $this->respond($response, Response::HTTP_CREATED)->setContentType('application/json');
        } catch (\Exception $e) {
            // Maneja la excepción de "Error al insertar el usuario en la base de datos." aquí
            $response = [
                'status'  => 'error',
                'message' => 'Error al crear el usuario',
                'exception' => $e
            ];
        
            return $this->respond($response, Response::HTTP_BAD_REQUEST)->setContentType('application/json');
        }

    }

    public function update($id)
    {
        $data = $this->request->getJSON();

        // Aplica las reglas de validación definidas en UserModel
        if (!$this->validate($this->userDAO->getValidationRules(), $this->userDAO->getValidationMessages())) {
            // Si la validación falla, retorna los errores
            return $this->respond(['status' => 'error', 'errors' => $this->validation->getErrors()], Response::HTTP_BAD_REQUEST);
        }
        
        try {
            $result = $this->userDAO->updateUser($id, $data);
            $response = [
                'status' => 'success',
                'message' => 'Usuario actualizado',
                'data'   => $result,
            ];
    
            return $this->respond($response, Response::HTTP_OK)->setContentType('application/json');
        } catch (\CodeIgniter\Exceptions\PageNotFoundException $e) {
            // Maneja la excepción de "Error al actualizar el usuario en la base de datos" aquí
            $response = [
                'status'  => 'error',
                'message' => $e->getMessage(),
                'data' => false,
            ];
    
            return $this->respond($response, Response::HTTP_NOT_FOUND)->setContentType('application/json');
        }
    }

    public function delete($id)
    {
        try {
            $user = $this->userDAO->deleteUser($id);
    
            $response = [
                'status' => 'success',
                'message' => 'Usuario eliminado correctamente',
                'data'   => $user,
            ];
    
            return $this->respond($response, Response::HTTP_OK)->setContentType('application/json');
        } catch (\CodeIgniter\Exceptions\PageNotFoundException $e) {
            // Maneja la excepción de "Error al eliminar el usuario en la base de datos" aquí
            $response = [
                'status'  => 'error',
                'message' => $e->getMessage(),
                'data' => false,
            ];
    
            return $this->respond($response, Response::HTTP_NOT_FOUND)->setContentType('application/json');
        }
    }
}
