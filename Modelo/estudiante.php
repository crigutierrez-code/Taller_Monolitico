<?php

namespace Modelo;

use mysqli;
use Exception;

class studen {
 private $name ;   
 private $code;
 private $email;

function __construct($name, $code, $email) {
    $this->name = $name;
    $this->code = $code;
    $this->email = $email;
}
public function getNombre(): string { return $this->name; }    
public function getCodigo(): string { return $this->code; }
public function getEmail(): string  { return $this->email;  }

public function guardar(mysqli $db): bool
    {
        $sql = "INSERT INTO estudiantes (nombre, codigo, email) VALUES (?, ?, ?)";
        $stmt = $db->prepare($sql);
        if (!$stmt) {
            throw new Exception('Error preparando consulta: ' . $db->error);
        }
        $stmt->bind_param('sss', $this->name, $this->code, $this->email);
        $ok = $stmt->execute();
        $stmt->close();
        return $ok;
    }

public static function crear(mysqli $db, string $nombre, string $codigo, string $email): self
    {
        $est = new studen ($nombre, $codigo, $email);
        $est->guardar($db);
        return $est;
    }

public static function getAll(mysqli $db): array
    {
        $sql    = "SELECT nombre, codigo, email FROM estudiantes";
        $result = $db->query($sql);

        $students = [];
        while ($row = $result->fetch_assoc()) {
            $students[] = new self(
                $row['nombre'],
                $row['codigo'],
                $row['email']
            );
        }
        return $students;
    }

public static function delet($name)
    {
        $sql = "SELECT nombre, notas FROM estudiantes , notas where nombre like {$name}";
        return $sql ;
    }
}
?>