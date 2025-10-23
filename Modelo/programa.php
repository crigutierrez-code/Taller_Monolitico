<?php

namespace Modelo;

use mysqli;
use Exception;

class program {
 private $code ;   
 private $name ;
function __construct($code, $name) {
    $this->code= $code;
    $this->name= $name;
}
public function getNombre(): string { return $this-> name; }    
public function getCodigo(): string { return $this-> code; }

public function guardar(mysqli $db): bool
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
        $est = new program ($code,  $name);
        $est->guardar($db);
        return $est;
    }

public static function getAll(mysqli $db): array
    {
        $sql    = "SELECT nombre, codigo FROM programa";
        $result = $db->query($sql);

        $program = [];
        while ($row = $result->fetch_assoc()) {
            $program[] = new self(
                $row['nombre'],
                $row['codigo']
            );
        }
        return $program;
    }

public static function delet($name)
    {
        $sql = "SELECT codigo  FROM programa where programa like {$name}";
        $sql1 = "SELECT nombre, programa  FROM materia where programa like {$sql}";
        return $sql1 ;
    }
}
?>