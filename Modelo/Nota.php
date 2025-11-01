<?php

namespace Modelo;

use mysqli;

class Nota
{
    private $materia;
    private $estudiante;
    private $actividad;
    private $nota;

    public function __construct($materia = null, $estudiante = null, $actividad = null, $nota = null)
    {
        $this->materia = $materia;
        $this->estudiante = $estudiante;
        $this->actividad = $actividad;
        $this->nota = $nota;
    }
    public static function guardar(mysqli $db, string $materia, string $estudiante, string $actividad, float $nota): bool
    {
        $stmt = $db->prepare("INSERT INTO notas (materia, estudiante, actividad, nota) VALUES (?,?,?,?)");
        $stmt->bind_param('sssd', $materia, $estudiante, $actividad, $nota);
        return $stmt->execute();
    }

    public static function actualizar(mysqli $db, string $materia, string $estudiante, string $actividad, float $nota): bool
    {
        $stmt = $db->prepare("UPDATE notas SET nota = ? WHERE materia = ? AND estudiante = ? AND actividad = ?");
        $stmt->bind_param('dsss', $nota, $materia, $estudiante, $actividad);
        return $stmt->execute();
    }

    public static function eliminarPorActividad(mysqli $db, string $materia, string $estudiante, string $actividad): bool
    {
        $stmt = $db->prepare("DELETE FROM notas WHERE materia = ? AND estudiante = ? AND actividad = ?");
        $stmt->bind_param('sss', $materia, $estudiante, $actividad);
        return $stmt->execute();
    }

    public static function getByClaveCompleta(mysqli $db, string $materia, string $estudiante, string $actividad): ?array
    {
        $stmt = $db->prepare("SELECT * FROM notas WHERE materia = ? AND estudiante = ? AND actividad = ? LIMIT 1");
        $stmt->bind_param('sss', $materia, $estudiante, $actividad);
        $stmt->execute();
        $res = $stmt->get_result();
        return $res->fetch_assoc() ?: null;
    }

    public static function getAll(mysqli $db): array
    {
        $sql    = "SELECT estudiante, materia, nota FROM notas";
        $res = $db->query($sql);
        return $res->fetch_all(MYSQLI_ASSOC);
    }

    public function getMateria(): ?string
    {
        return $this->materia;
    }
    public function getEstudiante(): ?string
    {
        return $this->estudiante;
    }
    public function getActividad(): ?string
    {
        return $this->actividad;
    }
    public function getNota(): ?float
    {
        return $this->nota;
    }
}
