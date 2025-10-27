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
        $sql    = "SELECT ocdigo, nombre, paragrama FROM  materias";
        $result = $db->query($sql);

        $students = [];
        while ($row = $result->fetch_assoc()) {
            $students[] = new self(
                $row['codigo'],
                $row['nombre'],
                $row['programa']
            );
        }
        return $students;
    }

    public static function delet($name)
    {
        $sql = "SELECT codigo  FROM materias where nombre like {$name}";
        $sql1 = "SELECT nombre, programa  FROM progarma where programa like {$sql}";
        return $sql1;
    }
}
