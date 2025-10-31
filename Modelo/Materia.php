<?php

namespace Modelo;

use mysqli;
use Exception;

class subject
{
    private $code;
    private $name;
    private $program;

    function __construct($code, $name, $program)
    {
        $this->code = $code;
        $this->name = $name;
        $this->program = $program;
    }
    public function getNombre(): string
    {
        return $this->code;
    }
    public function getCodigo(): string
    {
        return $this->name;
    }
    public function getEmail(): string
    {
        return $this->program;
    }

    public function guardar(mysqli $db): bool
    {
        $sql = "INSERT INTO  materias( codigo, nombre ,programa ) VALUES (?, ?, ?)";
        $stmt = $db->prepare($sql);
        if (!$stmt) {
            throw new Exception('Error preparando consulta: ' . $db->error);
        }
        $stmt->bind_param('sss', $this->code, $this->name, $this->program);
        $ok = $stmt->execute();
        $stmt->close();
        return $ok;
    }

    public static function crear(mysqli $db, string $code, string $name, string $program): self
    {
        $est = new subject($code, $name, $program);
        $est->guardar($db);
        return $est;
    }

    public static function getAll(mysqli $db): array
    {
        $sql    = "SELECT codigo, nombre, programa FROM  materias";
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
                $stmt = $db->prepare(
                    "DELETE FROM materias
                    WHERE programa IS NULL
                        OR programa NOT IN (SELECT codigo FROM programas)"
                );
                $stmt->execute();
                echo "Se eliminaron " . $stmt->affected_rows . " materias huérfanas.";
                }
        } else {
            echo "Hay programas asociados; no se eliminó nada.";
        }
    }
}
