<?php
namespace Controllers;

require_once __DIR__ . '/../Modelo/Conexion.php';
require_once __DIR__ . '/../Modelo/Estudiante.php';
require_once __DIR__ . '/../Modelo/Programa.php';
require_once __DIR__ . '/../Modelo/Nota.php';

use Modelo\Conexion;
use Modelo\Estudiante;
use Modelo\Program;
use Modelo\Nota;
class EstudiantesController
{
    private $db;
    public function __construct()
    {
        $this->db = (new Conexion())->getConexion();
    }
    public function listar(): void
    {
        $estudiantes = Estudiante::getAll($this->db);

        // CMD: salida simple
        foreach ($estudiantes as $e) {
            echo "{$e['codigo']} | {$e['nombre']} | {$e['email']} | {$e['programa']} <br>";
        }
    }

    public function crear()
    {
        $programas = Program::getAll($this->db);
        return $programas;
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
        $programas = Program::getAll($this->db);
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

    public function confirmarEliminar($codigo)
    {
        return $codigo;
    }

    public function eliminar($codigo)
    {
        if (empty($codigo)) {
            return false;
        }
        return Estudiante::eliminar($this->db, $codigo);
    }
};

$action = $_GET['action'] ?? 'list';

$controller = new EstudiantesController();
match ($action) {
    'list'   => $controller->listar(),
    default  => http_response_code(404) and exit('Acción no encontrada')
};
?>