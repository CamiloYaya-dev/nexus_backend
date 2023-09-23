<?php

namespace App\Database;

use CodeIgniter\Database\Postgre\Connection;
use Config\Database;

class DatabaseSingleton
{
    private static $instance = null;
    private $db;

    private function __construct()
    {
        // Configura la conexión a la base de datos
        $dbConfig = new Database();
        // Crea una instancia de Connection y pasa la configuración de default, si se necesitase otra solo seria cambiarlo como por ejemplo test
        $this->db = new Connection($dbConfig->default);
        $this->db->connect();
    }

    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function getConnection()
    {
        return $this->db;
    }
}