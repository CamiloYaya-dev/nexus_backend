<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'user'; // Nombre de tu tabla de usuarios
    protected $primaryKey = 'id'; // Nombre de la clave primaria de la tabla
    protected $allowedFields = ['name', 'email', 'age']; // Campos permitidos para inserción y actualización
    // Reglas de validación
    protected $validationRules = [
        'name' => 'required|string|max_length[255]',
        'email' => 'required|string|max_length[255]|valid_email',
        'age' => 'required|integer',
    ];

    // Mensajes de error personalizados
    protected $validationMessages = [
        'name' => [
            'required' => 'El campo Nombre es obligatorio.',
            'string' => 'El campo Nombre debe ser una cadena de texto.',
            'max_length' => 'El campo Nombre no puede tener más de 255 caracteres.',
        ],
        'email' => [
            'required' => 'El campo Correo Electrónico es obligatorio.',
            'string' => 'El campo Correo Electrónico debe ser una cadena de texto.',
            'max_length' => 'El campo Correo Electrónico no puede tener más de 255 caracteres.',
            'valid_email' => 'El campo Correo Electrónico debe ser una dirección de correo electrónico válida.',
        ],
        'age' => [
            'integer' => 'El campo Edad debe ser un número entero.',
        ],
    ];

    public function findAll(int $limit = 0, int $offset = 0)
    {
        try {
            $result = parent::findAll($limit, $offset);

            if (empty($result)) {
                throw new \CodeIgniter\Exceptions\PageNotFoundException('No se encontraron usuarios.');
            }

            return $result;
        } catch (\Exception $e) {
            // Maneja la excepción aquí y regístrala o lánzala nuevamente si es necesario
            log_message('error', $e->getMessage());
            throw $e; // Lanza la excepción nuevamente para que se pueda manejar en el controlador
        }
    }

    public function find($id = null, $columns = '*')
    {
        try {
            $result = parent::find($id, $columns);

            if ($result === null) {
                throw new \CodeIgniter\Exceptions\PageNotFoundException("Usuario no encontrado para el ID: $id");
            }

            return $result;
        } catch (\Exception $e) {
            // Maneja la excepción aquí y regístrala o lánzala nuevamente si es necesario
            log_message('error', $e->getMessage());
            throw $e; // Lanza la excepción nuevamente para que se pueda manejar en el controlador
        }
    }

    // Personaliza el método insert para devolver la data o errores
    public function insert($data = null, bool $returnID = true, bool $overwrite = false)
    {
        try {
            $result = parent::insert($data, $returnID, $overwrite);

            if ($result === false) {
                throw new \Exception('Error al insertar el usuario en la base de datos.');
            }

            return $result; // Devuelve el resultado exitoso
        } catch (\Exception $e) {
            // Maneja la excepción aquí y regístrala o lánzala nuevamente si es necesario
            log_message('error', $e->getMessage());
            throw $e; // Lanza la excepción nuevamente para que se pueda manejar en el controlador
        }
    }

    // En tu modelo UserModel.php
    public function customUpdate($id = null, $data = null)
    {
        try {
            // Verifica si el usuario existe antes de intentar actualizarlo
            $user = $this->find($id);
            
            if ($user === null) {
                throw new \CodeIgniter\Exceptions\PageNotFoundException("Usuario no encontrado para el ID: $id");
            }
            
            $result = $this->update($id, $data);

            if ($result === false) {
                throw new \Exception('Error al actualizar el usuario en la base de datos.');
            }

            return $result; // Devuelve el resultado exitoso
        } catch (\Exception $e) {
            // Maneja la excepción aquí y regístrala o lánzala nuevamente si es necesario
            log_message('error', $e->getMessage());
            throw $e; // Lanza la excepción nuevamente para que se pueda manejar en el controlador
        }
    }



    public function delete($id = null, bool $purge = false)
    {
        try {
            // Verifica si el usuario existe antes de intentar eliminarlo
            $user = $this->find($id);
            
            if ($user === null) {
                throw new \CodeIgniter\Exceptions\PageNotFoundException("Usuario no encontrado para el ID: $id");
            }
            
            $result = parent::delete($id, $purge);

            if ($result === false) {
                throw new \Exception('Error al eliminar el usuario en la base de datos.');
            }

            return $result; // Devuelve el resultado exitoso
        } catch (\Exception $e) {
            // Maneja la excepción aquí y regístrala o lánzala nuevamente si es necesario
            log_message('error', $e->getMessage());
            throw $e; // Lanza la excepción nuevamente para que se pueda manejar en el controlador
        }
    }
}
