<?php

namespace Modelo;

use mysqli;
use Exception;

class Programa
{
    private $code;
    private $name;
    function __construct($code, $name)
    {
        $this->code = $code;
        $this->name = $name;
    }
    public  function getNombre(): string
    {
        return $this->name;
    }
    public function getCodigo(): string
    {
        return $this->code;
    }

    public  function guardar(mysqli $db): bool
    {
        $sql = "INSERT INTO programas (codigo, nombre) VALUES (?, ?)";
        $stmt = $db->prepare($sql);
        if (!$stmt) {
            throw new Exception('Error preparando consulta: ' . $db->error);
        }
        $stmt->bind_param('ss', $this->code, $this->name);
        $ok = $stmt->execute();
        $stmt->close();
        return $ok;
    }

    public function actualizar(mysqli $db): bool
    {
        /*
        if (self::tieneRelaciones($db, $this->code)) {
            return false;
        }
            */

        $sql = "UPDATE programas SET nombre = ? WHERE codigo = ?";
        $stmt = $db->prepare($sql);
        if (!$stmt) throw new Exception('Error preparando consulta: ' . $db->error);

        $stmt->bind_param('ss', $this->name, $this->code);
        $ok = $stmt->execute();
        $stmt->close();
        return $ok;
    }


    public static function eliminar(mysqli $db, string $codigo): bool
    {
        /*
        if (self::tieneRelaciones($db, $codigo)) {
            return false;
        }
            */
       
        $sql = "DELETE FROM programas WHERE codigo = ?";
        $stmt = $db->prepare($sql);
        $stmt->bind_param('s', $codigo);
        $ok = $stmt->execute();
        $stmt->close();
        return $ok;
    }
/*
    public static function tieneRelaciones(mysqli $db, string $codigo): bool
    {
        $sql_est = "SELECT COUNT(*) as c FROM estudiantes WHERE programa = $codigo";
        $stmt_est = $db->prepare($sql_est);
        $stmt_est->bind_param('s', $codigo);
        $stmt_est->execute();
        if (intval($stmt_est->get_result()->fetch_assoc()['c']) > 0) {
            $stmt_est->close();
            return true;
        }
        $stmt_est->close();

        $sql_mat = "SELECT COUNT(*) as c FROM materias WHERE programa = ?";
        $stmt_mat = $db->prepare($sql_mat);
        $stmt_mat->bind_param('s', $codigo);
        $stmt_mat->execute();
        if (intval($stmt_mat->get_result()->fetch_assoc()['c']) > 0) {
            $stmt_mat->close();
            return true;
        }
        $stmt_mat->close();

        return false;
    }*/

    public static function crear(mysqli $db, string $code, string $name): self
    {
        $est = new self($code,  $name);
        $est->guardar($db);
        return $est;
    }

    public static function getAll(mysqli $db): array
    {
        $sql    = "SELECT codigo, nombre FROM programas";
        $res = $db->query($sql);
        return $res->fetch_all(MYSQLI_ASSOC);
    }


    public static function getByCodigo(mysqli $db, string $codigo): ?self
    {
        $sql = "SELECT codigo, nombre FROM programas WHERE codigo = ?";
        $stmt = $db->prepare($sql);
        $stmt->bind_param('s', $codigo);
        $stmt->execute();
        $res = $stmt->get_result();
        if ($row = $res->fetch_assoc()) {
            return new self($row['codigo'], $row['nombre']);
        }
        return null;
    }
}
