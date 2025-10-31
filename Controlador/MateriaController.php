<?php


require __DIR__ . '/../Modelo/Conexion.php';
require __DIR__ . '/../Modelo/Materia.php';
require __DIR__ . '/../Modelo/Programa.php';

use Modelo\Conexion;
use Modelo\subject;
use Modelo\Program;

class MateriasController
{
    private $db;

    public function __construct()
    {
        $this->db = (new Conexion())->getConexion();
    }

     public function listar(): void
    {
        $subject = subject::getAll($this->db);

        // CMD: salida simple
        foreach ($subject as $e) {
            echo "{$e['codigo']} | {$e['nombre']} | {$e['programa']} <br>" ;
        }
    }

    public function crear()
    {
        return Program::getAll($this->db);
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
        $m = new subject(
            $request['codigo'],
            $request['nombre'],
            $request['programa']
        );
        return $m->guardar($this->db);
    }

    public function editar($codigo)
    {
        $list = subject::getAll($this->db);
        $selected = null;
        foreach ($list as $x) {
            if ($x->getCodigo() === $codigo) {
                $selected = $x;
                break;
            }
        }
        $programas = Program::getAll($this->db);
        return ['materia' => $selected, 'programas' => $programas];
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
        $m = new subject(
            $request['codigo'],
            $request['nombre'],
            $request['programa']
        );
        //return $m->(crear funcion para actualizar)($this->db);
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
        return subject::delet($this->db, $codigo);
    }
};

$action = $_GET['action'] ?? 'list';

$controller = new MateriasController();
match ($action) {
    'list'   => $controller->listar(),
    default  => http_response_code(404) and exit('Acción no encontrada')
};
?>