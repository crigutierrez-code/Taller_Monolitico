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

    
    public function listarPromediosPorMateriaYEstudiante()
{
    $sql = "SELECT 
                n.materia AS codigo_materia, 
                m.nombre AS nombre_materia,
                n.estudiante AS codigo_estudiante, 
                e.nombre AS nombre_estudiante,
                ROUND(AVG(n.nota), 2) AS promedio
            FROM notas n
            JOIN estudiantes e ON n.estudiante = e.codigo
            JOIN materias m ON n.materia = m.codigo
            GROUP BY n.materia, n.estudiante, m.nombre, e.nombre
            ORDER BY m.nombre, e.nombre";

    $res = $this->db->query($sql);
    $promedios = [];
    while ($r = $res->fetch_assoc()) {
        $promedios[] = $r;
    }
    return $promedios;
}

public function listarNotasDetallePorEstudianteYMateria(string $materia_cod, string $estudiante_cod)
{
    $sql = "SELECT 
                n.actividad, 
                n.nota
            FROM notas n
            WHERE n.materia = ? AND n.estudiante = ?";

    $stmt = $this->db->prepare($sql);
    $stmt->bind_param('ss', $materia_cod, $estudiante_cod);
    $stmt->execute();
    $res = $stmt->get_result();

    $detalles = [];
    while ($r = $res->fetch_assoc()) {
        $detalles[] = $r;
    }
    return $detalles;
}

    public function listarDetalle()
    {
        $sql = "SELECT n.id, n.materia, n.estudiante, n.actividad, n.nota,
            e.nombre AS nombre_estudiante, m.nombre AS nombre_materia
            FROM notas n
            JOIN estudiantes e ON n.estudiante = e.codigo
            LEFT JOIN materias m ON n.materia = m.codigo
            ORDER BY n.id DESC";

        $res = $this->db->query($sql);
        if (!$res) {
            error_log("SQL listarDetalle error: " . $this->db->error);
            return [];
        }

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
