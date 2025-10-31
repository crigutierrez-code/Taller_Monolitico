<?php

require __DIR__ . '/../Modelo/Conexion.php';
require __DIR__ . '/../Modelo/Programa.php';

use Modelo\Conexion;
use Modelo\program;

class ProgramasController
{
    private $db;

    public function __construct()
    {
        $this->db = (new Conexion())->getConexion();
    }

    public function listar(): void
    {
        $estudiantes = Program::getAll($this->db);

        // CMD: salida simple
        foreach ($estudiantes as $e) {
            echo "{$e['codigo']} | {$e['nombre']}  <br>" ;
        }
    }

    public function crear()
    {
        return true; // no necesita datos adicionales
    }

    public function guardar($request)
    {
        if (
            empty($request['codigo']) ||
            empty($request['nombre'])
        ) {
            return false;
        }
        $p = new Program($request['codigo'], $request['nombre']);
        return $p->guardar($this->db);
    }

    public function editar($codigo)
    {
        $list = Program::getAll($this->db);
        foreach ($list as $x) {
            if ($x->getCodigo() === $codigo) {
                return $x;
            }
        }
        return null;
    }

    public function actualizar($request)
    {
        if (
            empty($request['codigo']) ||
            empty($request['nombre'])
        ) {
            return false;
        }
        $p = new Program($request['codigo'], $request['nombre']);
        //return $p->(crear metodo para catualizar nombre)($this->db);
    }

    public function confirmarEliminar($codigo)
    {
        return $codigo;
    }

    public function eliminar($codigo)
    {
        if (empty($codigo)) {
            return false;
        }
        return Program::delet($this->db, $codigo);
    }
};

$action = $_GET['action'] ?? 'list';

$controller = new ProgramasController();
match ($action) {
    'list'   => $controller->listar(),
    default  => http_response_code(404) and exit('Acción no encontrada')
};
?>