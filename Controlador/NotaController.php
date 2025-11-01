<?php
require __DIR__ . '/../Modelo/Conexion.php';
require __DIR__ . '/../Modelo/Nota.php';
require __DIR__ . '/../Modelo/Estudiante.php';
require __DIR__ . '/../Modelo/Materia.php';

use Modelo\Conexion;
use Modelo\Nota;
use Modelo\Estudiante;
use Modelo\subject;

class NotasController
{
    private $db;

    public function __construct()
    {
        $this->db = (new Conexion())->getConexion();
    }

    public function listar(): void
    {
        $subject = Nota::getAll($this->db);

        // CMD: salida simple
        foreach ($subject as $e) {
            echo "{$e['id']} | {$e['materia']} | {$e['estudiante']} | {$e['actividad']} | {$e['nota']} <br>" ;
        }
    }

    public function listarDetalle()
    {
        $sql = "SELECT n.id, n.materia, n.estudiante, n.actividad, n.nota, n.fecha_registro,
                e.nombre as nombre_estudiante, m.nombre as nombre_materia
                FROM notas n
                JOIN estudiantes e ON n.estudiante = e.codigo
                JOIN materias m ON n.materia = m.codigo
                ORDER BY n.fecha_registro DESC";
        $res = $this->db->query($sql);
        $notas_detalle = [];
        while ($r = $res->fetch_assoc()) {
            $notas_detalle[] = $r;
        }
        return $notas_detalle;
    }

    public function crear()
    {
        $estudiantes = Estudiante::getAll($this->db);
        $materias = subject::getAll($this->db);
        return ['estudiantes' => $estudiantes, 'materias' => $materias];
    }

    public function guardar($request)
    {
        if (
            empty($request['materia']) ||
            empty($request['estudiante']) ||
            empty($request['actividad']) ||
            !isset($request['nota'])
        ) {
            return false;
        }
        return Nota::guardar(
            $this->db,
            $request['materia'],
            $request['estudiante'],
            $request['actividad'],
            floatval($request['nota'])
        );
    }

    public function editar($materia, $estudiante, $actividad)
    {
        return Nota::getByClaveCompleta($this->db, $materia, $estudiante, $actividad);
    }

    public function actualizar($request)
    {
        if (
            empty($request['materia']) ||
            empty($request['estudiante']) ||
            empty($request['actividad']) ||
            !isset($request['nota'])
        ) {
            return false;
        }
        return Nota::actualizar(
            $this->db,
            $request['materia'],
            $request['estudiante'],
            $request['actividad'],
            floatval($request['nota'])
        );
    }

    public function confirmarEliminar()
    {
        return true;
    }

    public function eliminar($materia, $estudiante, $actividad)
    {
        if (empty($materia) || empty($estudiante) || empty($actividad)) {
            return false;
        }
        return Nota::eliminarPorActividad($this->db, $materia, $estudiante, $actividad);
    }
}

$action = $_GET['action'] ?? 'list';

$controller = new NotasController();
match ($action) {
    'list'   => $controller->listar(),
    default  => http_response_code(404) and exit('Acción no encontrada')
};
?>