<?php
namespace Controllers;

require __DIR__ . '/../Modelo/Conexion.php';
require __DIR__ . '/../Modelo/Nota.php';
require __DIR__ . '/../Modelo/Estudiante.php';
require __DIR__ . '/../Modelo/Materia.php';

use Modelo\Conexion;
use Modelo\Nota;
use Modelo\Estudiante;
use Modelo\Materia;

class NotasController
{
    private $db;

    public function __construct()
    {
        $this->db = (new Conexion())->getConexion();
    }

    public function listar()
    {
        $sql = "SELECT n.materia, n.estudiante, ROUND(AVG(n.nota),2) as promedio
                FROM notas n
                GROUP BY n.materia, n.estudiante
                ORDER BY n.materia, n.estudiante";
        $res = $this->db->query($sql);
        $promedios = [];
        while ($r = $res->fetch_assoc()) {
            $promedios[] = $r;
        }
        return $promedios;
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
        $materias = Materia::getAll($this->db);
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