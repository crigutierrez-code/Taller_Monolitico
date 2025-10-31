<?php

namespace Modelo;

use mysqli;
use Exception;

class program
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

    public static function crear(mysqli $db, string $code, string $name): self
    {
        $est = new program($code,  $name);
        $est->guardar($db);
        return $est;
    }

    public static function getAll(mysqli $db): array
    {
        $sql    = "SELECT codigo, nombre FROM programas";
        $res = $db->query($sql);
        return $res->fetch_all(MYSQLI_ASSOC);
    }

    public static function delet($name)
    {
        $db = (new Conexion())->getConexion();
        $name = trim($_GET['name'] ?? '');

        if ($name === '') {
            echo "Nombre vacío";
            exit;
        }

        $stmt = $db->prepare("SELECT DISTINCT p.codigo
                            FROM programas p
                            JOIN materias m ON p.codigo = m.programa
                            WHERE m.nombre LIKE CONCAT(?, '%')");
        $stmt->bind_param('s', $name);
        $stmt->execute();
        $res = $stmt->get_result();

        if ($res->num_rows === 0) {
            $sel = $db->prepare("SELECT DISTINCT programa
                                FROM materias
                                WHERE nombre LIKE CONCAT(?, '%')");
            $sel->bind_param('s', $name);
            $sel->execute();
            $progCodes = array_column($sel->get_result()->fetch_all(MYSQLI_ASSOC), 'programa');

            if ($progCodes) {
                $place = implode(',', array_fill(0, count($progCodes), '?'));
                $del = $db->prepare("DELETE FROM programas WHERE codigo IN ($place)");
                $del->bind_param(str_repeat('s', count($progCodes)), ...$progCodes);
                $del->execute();
                echo "Se eliminaron los programas: " . htmlspecialchars(implode(', ', $progCodes));
            }
        } else {
            echo "Hay programas asociados; no se eliminó nada.";
        }
    }
}
