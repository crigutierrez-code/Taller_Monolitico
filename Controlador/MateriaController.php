<?php
namespace Controllers;

require_once __DIR__ . '/../Modelo/Conexion.php';
require_once __DIR__ . '/../Modelo/Materia.php';
require_once __DIR__ . '/../Modelo/Programa.php';

use Modelo\Conexion;
use Modelo\Materia;
use Modelo\Programa;

class MateriasController
{
    private $db;

    public function __construct()
    {
        $this->db = (new Conexion())->getConexion();
    }

    public function listar()
    {
        return Materia::getAll($this->db);
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
            empty($request['programa'])
        ) {
            return false;
        }
        $m = new Materia(
            $request['codigo'],
            $request['nombre'],
            $request['programa']
        );
        return $m->guardar($this->db);
    }

    public function editar($codigo)
    {
        $materia = Materia::getByCodigo($this->db, $codigo);
        $programas = Programa::getAll($this->db);
        return ['materia' => $materia, 'programas' => $programas];
    }

    public function actualizar($request)
    {
        if (
            empty($request['codigo']) ||
            empty($request['nombre']) ||
            empty($request['programa'])
        ) {
            return false;
        }
        $m = new Materia(
            $request['codigo'],
            $request['nombre'],
            $request['programa']
        );
        
        return $m->actualizar($this->db);
    }

    public function eliminar($codigo)
    {
        if (empty($codigo)) {
            return false;
        }
        return Materia::eliminar($this->db, $codigo);
    }
}
?>