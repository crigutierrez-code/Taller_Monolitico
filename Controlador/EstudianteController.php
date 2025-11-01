<?php

namespace Controllers;

require_once __DIR__ . '/../Modelo/Conexion.php';
require_once __DIR__ . '/../Modelo/Estudiante.php';
require_once __DIR__ . '/../Modelo/Programa.php';
require_once __DIR__ . '/../Modelo/Nota.php';

use Modelo\Conexion;
use Modelo\Estudiante;
use Modelo\Programa;
use Modelo\Nota;

class EstudiantesController
{
    private $db;
    public function __construct()
    {
        $this->db = (new Conexion())->getConexion();
    }


    public function listar()
    {
        
        return Estudiante::getAllConPrograma($this->db);
    }

    public function crear()
    {
        return Programa::getAll($this->db);
    }

    public function guardar($request)
    {
        if (
            empty($request['codigo']) ||
            empty($request['nombre']) ||
            empty($request['email']) ||
            empty($request['programa'])
        ) {
            return false;
        }
        $est = new Estudiante(
            $request['codigo'],
            $request['nombre'],
            $request['email'],
            $request['programa']
        );
        return $est->guardar($this->db);
    }

    public function editar($codigo)
    {
        $est = Estudiante::getByCodigo($this->db, $codigo);
        $programas = Programa::getAll($this->db);
        return ['estudiante' => $est, 'programas' => $programas];
    }

    public function actualizar($request)
    {
        if (
            empty($request['codigo']) ||
            empty($request['nombre']) ||
            empty($request['email']) ||
            empty($request['programa'])
        ) {
            return false;
        }

        if (Estudiante::tieneNotas($this->db, $request['codigo'])) {
            return false;
        }

        $est = new Estudiante(
            $request['codigo'],
            $request['nombre'],
            $request['email'],
            $request['programa']
        );
        return $est->actualizar($this->db);
    }

    public function eliminar($codigo)
    {
        if (empty($codigo)) {
            return false;
        }

        if (Estudiante::tieneNotas($this->db, $codigo)) {
            return false;
        }
        
        try {
             return Estudiante::eliminar($this->db, $codigo);
        } catch (\Exception $e) {
            return false;
        }
    }
}
?>