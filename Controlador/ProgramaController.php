<?php

namespace Controllers;

require_once __DIR__ . '/../Modelo/Conexion.php';
require_once __DIR__ . '/../Modelo/Programa.php';

use Modelo\Conexion;
use Modelo\Programa;

class ProgramasController
{
    private $db;

    public function __construct()
    {
        $this->db = (new Conexion())->getConexion();
    }

    public function listar()
    {
        return Programa::getAll($this->db);
    }

    public function crear()
    {
        return true;
    }

    public function guardar($request)
    {
        if (
            empty($request['codigo']) ||
            empty($request['nombre'])
        ) {
            return false;
        }
        $p = new Programa($request['codigo'], $request['nombre']);
        return $p->guardar($this->db);
    }

    public function editar($codigo)
    {
        return Programa::getByCodigo($this->db, $codigo);
    }

    public function actualizar($request)
    {
        if (
            empty($request['codigo']) ||
            empty($request['nombre'])
        ) {
            return false;
        }
        $p = new Programa($request['codigo'], $request['nombre']);

        return $p->actualizar($this->db);
    }

    public function eliminar($codigo)
    {
        if (empty($codigo)) {
            return false;
        }

        return Programa::eliminar($this->db, $codigo);
    }
}
