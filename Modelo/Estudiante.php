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

    public function __construct($codigo = null, $nombre = null, $email = null, $programa = null)
    {
        $this->codigo = $codigo;
        $this->nombre = $nombre;
        $this->email = $email;
        $this->programa = $programa;
    }

    public function getCodigo()
    {
        return $this->codigo;
    }
    public function getNombre()
    {
        return $this->nombre;
    }
    public function getEmail()
    {
        return $this->email;
    }
    public function getPrograma()
    {
        return $this->programa;
    }

    public function guardar(mysqli $db): bool
    {
        $sql = "INSERT INTO estudiantes (codigo, nombre, email, programa) VALUES (?, ?, ?, ?)";
        $stmt = $db->prepare($sql);

        if (!$stmt) {

            throw new Exception('Error preparando consulta: ' . $db->error);
        }

        $stmt->bind_param('ssss', $this->codigo, $this->nombre, $this->email, $this->programa);

        if ($stmt->execute()) {
            $stmt->close();
            return true;
        } else {
            $error = $stmt->error;
            $stmt->close();
            throw new Exception('Error al ejecutar la consulta (guardar): ' . $error);
        }
    }

    public function actualizar(mysqli $db): bool
    {
        $stmt = $db->prepare("SELECT 1 FROM notas WHERE estudiante = ? LIMIT 1");
        $stmt->bind_param('s', $this->codigo);
        $stmt->execute();
        $tieneNotas = $stmt->get_result()->fetch_assoc() !== null;
        $stmt->close();

        if ($tieneNotas) {
            return false;   // No se puede borrar
        }

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
            return false;
        }

        // 2. Borrar estudiante
        $stmt = $db->prepare("DELETE FROM estudiantes WHERE codigo = ?");
        $stmt->bind_param('s', $codigo);
        $ok = $stmt->execute();
        $stmt->close();

        return $ok;
    }

    public static function getAllConPrograma(mysqli $db): array
    {
        $sql = "SELECT e.codigo, e.nombre, e.email, p.nombre as programa_nombre
                FROM estudiantes e
                JOIN programas p ON e.programa = p.codigo";
        $res = $db->query($sql);
        return $res->fetch_all(MYSQLI_ASSOC);
    }
}
