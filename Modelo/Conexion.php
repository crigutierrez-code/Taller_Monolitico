<?php

namespace Modelo;

use mysqli;
use Exception;

class Conexion
{
    private $host = "localhost";
    private $user = "root";
    private $pass = "";
    private $db = "notas_app";
    private $conexion;

    public function __construct()
    {
        $this->conexion = new mysqli(
            $this->host,
            $this->user,
            $this->pass,
            $this->db
        );
        if ($this->conexion->connect_error) {
            throw new Exception("Error de conexión: " . $this->conexion->connect_error);
        }
        $this->conexion->set_charset('utf8mb4');
    }

    public function getConexion(): mysqli
    {
        return $this->conexion;
    }
}
