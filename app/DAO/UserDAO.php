<?php

namespace App\DAO;

use App\Models\UserModel;
use App\Database\DatabaseSingleton;

class UserDAO
{
    protected $db; // La instancia de la conexión a la base de datos
    protected $userModel;

    public function __construct()
    {
        $this->db = DatabaseSingleton::getInstance()->getConnection();
        $this->userModel = new UserModel($this->db);
    }

     // Obtener todos los usuarios
     public function getAllUsers()
     {
        //A partir de este punto, todas las operaciones de base de datos que se realicen se considerarán parte de la misma transacción.
        $this->db->transStart();
        $result = $this->userModel->findAll();
        //Si todas las operaciones de la transacción se realizaron con éxito, la transacción se confirma y los cambios se guardan en la base de datos.
        //Si alguna operación falla, la transacción se deshace y se revierten todas las operaciones anteriores.
        $this->db->transComplete();
        return $result;
     }
 
     // Obtener usuario por ID
     public function getUserByID($id)
     {
        //A partir de este punto, todas las operaciones de base de datos que se realicen se considerarán parte de la misma transacción.
        $this->db->transStart();
        $result = $this->userModel->find($id);
        //Si todas las operaciones de la transacción se realizaron con éxito, la transacción se confirma y los cambios se guardan en la base de datos.
        //Si alguna operación falla, la transacción se deshace y se revierten todas las operaciones anteriores.
        $this->db->transComplete();
        return $result;
     }
 
     // Crear un usuario
     public function createUser($data)
     {
        //A partir de este punto, todas las operaciones de base de datos que se realicen se considerarán parte de la misma transacción.
        $this->db->transStart();
        $result = $this->userModel->insert($data);
        //Si todas las operaciones de la transacción se realizaron con éxito, la transacción se confirma y los cambios se guardan en la base de datos.
        //Si alguna operación falla, la transacción se deshace y se revierten todas las operaciones anteriores.
        $this->db->transComplete();
        return $result;
     }
 
     // Editar usuario por ID
     public function updateUser($id, $data)
     {
        //A partir de este punto, todas las operaciones de base de datos que se realicen se considerarán parte de la misma transacción.
        $this->db->transStart();
        $result = $this->userModel->customUpdate($id, $data);
        //Si todas las operaciones de la transacción se realizaron con éxito, la transacción se confirma y los cambios se guardan en la base de datos.
        //Si alguna operación falla, la transacción se deshace y se revierten todas las operaciones anteriores.
        $this->db->transComplete();
        return $result;
     }
 
     // Eliminar usuario por ID
     public function deleteUser($id)
     {
        //A partir de este punto, todas las operaciones de base de datos que se realicen se considerarán parte de la misma transacción.
        $this->db->transStart();
        $result = $this->userModel->delete($id);
        //Si todas las operaciones de la transacción se realizaron con éxito, la transacción se confirma y los cambios se guardan en la base de datos.
        //Si alguna operación falla, la transacción se deshace y se revierten todas las operaciones anteriores.
        $this->db->transComplete();
        return $result;
     }

     public function getValidationRules(){
        return $this->userModel->getValidationRules();
     }

     public function getValidationMessages(){
        return $this->userModel->getValidationMessages();
     }
}
