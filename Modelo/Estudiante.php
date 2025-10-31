<?php

namespace Modelo;

use mysqli;
use Exception;

class Estudiante
{
    private $codigo;
    private $nombre;
    private $email;
    private $programa;

    public function __construct(string $codigo, string $nombre, string $email, string $programa)
    {
        $this->codigo = $codigo;
        $this->nombre = $nombre;
        $this->email = $email;
        $this->programa = $programa;
    }

    public function getCodigo(): string
    {
        return $this->codigo;
    }
    public function getNombre(): string
    {
        return $this->nombre;
    }
    public function getEmail(): string
    {
        return $this->email;
    }
    public function getPrograma(): string
    {
        return $this->programa;
    }

    public function guardar(mysqli $db): bool
    {
        $sql = "INSERT INTO estudiantes (codigo, nombre, email, programa) VALUES (?, ?, ?, ?)";
        $stmt = $db->prepare($sql);

        if (!$stmt) throw new Exception('Error preparando consulta: ' . $db->error);
        
        $stmt->bind_param('ssss', $this->codigo, $this->nombre, $this->email, $this->programa);
        $ok = $stmt->execute();
        $stmt->close();
        return $ok;
    }

    public function actualizar(mysqli $db): bool
    {
        // no permite cambiar el código; se debe validar antes que no tenga notas
        $sql = "UPDATE estudiantes SET nombre = ?, email = ?, programa = ? WHERE codigo = ?";
        $stmt = $db->prepare($sql);
        if (!$stmt) throw new Exception('Error preparando consulta: ' . $db->error);
        $stmt->bind_param('ssss', $this->nombre, $this->email, $this->programa, $this->codigo);
        $ok = $stmt->execute();
        $stmt->close();
        return $ok;
    }

     public static function getAll(mysqli $db): array
    {
        $sql = "SELECT codigo, nombre, email, programa FROM estudiantes";
        $res = $db->query($sql);
        return $res->fetch_all(MYSQLI_ASSOC);
    }

    public static function getByCodigo(mysqli $db, string $codigo): ?self
    {
        $sql = "SELECT codigo, nombre, email, programa FROM estudiantes WHERE codigo = ?";
        $stmt = $db->prepare($sql);
        if (!$stmt) throw new Exception($db->error);
        $stmt->bind_param('s', $codigo);
        $stmt->execute();
        $res = $stmt->get_result();
        if ($row = $res->fetch_assoc()) {
            return new self($row['codigo'], $row['nombre'], $row['email'], $row['programa']);
        }
        return null;
    }

    public static function tieneNotas(mysqli $db, string $codigo): bool
    {
        $sql = "SELECT COUNT(*) as c FROM notas WHERE estudiante = ?";
        $stmt = $db->prepare($sql);
        $stmt->bind_param('s', $codigo);
        $stmt->execute();
        $r = $stmt->get_result()->fetch_assoc();
        return intval($r['c']) > 0;
    }

    public static function eliminar(mysqli $db, string $codigo): bool
    {
        if (self::tieneNotas($db, $codigo)) {
            throw new Exception("No se puede eliminar: estudiante tiene notas registradas.");
        }
        $sql = "DELETE FROM estudiantes WHERE codigo = ?";
        $stmt = $db->prepare($sql);
        $stmt->bind_param('s', $codigo);
        $ok = $stmt->execute();
        $stmt->close();
        return $ok;
    }
}
