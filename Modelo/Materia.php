<?php
namespace Modelo;

use mysqli;
use Exception;


class Materia
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


    public function getCodigo(): string
    {
        return $this->code;
    }
    public function getNombre(): string
    {
        return $this->name;
    }
    public function getPrograma(): string
    {
        return $this->program;
    }
    

    public function guardar(mysqli $db): bool
    {
        $sql = "INSERT INTO materias (codigo, nombre, programa) VALUES (?, ?, ?)";
        $stmt = $db->prepare($sql);
        if (!$stmt) {
            throw new Exception('Error preparando consulta: ' . $db->error);
        }
        $stmt->bind_param('sss', $this->code, $this->name, $this->program);
        $ok = $stmt->execute();
        $stmt->close();
        return $ok;
    }

    public function actualizar(mysqli $db): bool
    {
        if (self::tieneNotas($db, $this->code)) {
            return false;
        }
        
        $sql = "UPDATE materias SET nombre = ?, programa = ? WHERE codigo = ?";
        $stmt = $db->prepare($sql);
        if (!$stmt) throw new Exception('Error preparando consulta: ' . $db->error);
        
        $stmt->bind_param('sss', $this->name, $this->program, $this->code);
        $ok = $stmt->execute();
        $stmt->close();
        return $ok;
    }

   /* private static function estaEnUso(mysqli $db, string $codigo): bool
{
    // 1. ¿Tiene notas?
    $sql = $db->prepare("SELECT codiog FROM notas WHERE materias = $codigo LIMIT 1");
    $sql->bind_param('s', $codigo);
    $sql->execute();
    $enNotas = $sql->get_result()->fetch_assoc() !== null;
    $sql->close();
    if ($enNotas) return true;

    // 2. ¿Hay estudiantes en el programa al que pertenece esta materia?
    $stmt = $db->prepare(
        "SELECT 1
         FROM estudiantes e
         JOIN materias m ON m.programas = e.programas
         WHERE m.codigo = ?
         LIMIT 1"
    );
    $stmt->bind_param('s', $codigo);
    $stmt->execute();
    $enEstudiantes = $stmt->get_result()->fetch_assoc() !== null;
    $stmt->close();

    return $enEstudiantes;
}*/
    public static function eliminar(mysqli $db, string $codigo): bool
    {

        if (self::tieneNotas($db, $codigo)) {
            return false;
        }
        /*
               if (self::estaEnUso($db, $codigo)) {
        return false; // No se puede borrar
        }
*/
        $sql = "DELETE FROM materias WHERE codigo = ?";
        $stmt = $db->prepare($sql);
        $stmt->bind_param('s', $codigo);
        $ok = $stmt->execute();
        $stmt->close();
        return $ok;
    }


    public static function tieneNotas(mysqli $db, string $codigo): bool
    {
        $sql = "SELECT COUNT(*) as c FROM notas WHERE materia = ?";
        $stmt = $db->prepare($sql);
        $stmt->bind_param('s', $codigo);
        $stmt->execute();
        $r = $stmt->get_result()->fetch_assoc();
        return intval($r['c']) > 0;
    }


    public static function crear(mysqli $db, string $code, string $name, string $program): self
    {
        $est = new self($code, $name, $program);
        $est->guardar($db);
        return $est;
    }

    public static function getAll(mysqli $db): array
    {
        $sql    = "SELECT codigo, nombre, programa FROM materias";
        $res = $db->query($sql);
        return $res->fetch_all(MYSQLI_ASSOC);
    }
    
    public static function getByCodigo(mysqli $db, string $codigo): ?self
    {
        $sql = "SELECT codigo, nombre, programa FROM materias WHERE codigo = ?";
        $stmt = $db->prepare($sql);
        $stmt->bind_param('s', $codigo);
        $stmt->execute();
        $res = $stmt->get_result();
        if ($row = $res->fetch_assoc()) {
            return new self($row['codigo'], $row['nombre'], $row['programa']);
        }
        return null;
    }
}