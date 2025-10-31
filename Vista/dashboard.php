<?php
require_once __DIR__ . '/../Modelo/Conexion.php';
require_once __DIR__ . '/../Modelo/Estudiante.php';
require_once __DIR__ . '/../Modelo/Programa.php';
require_once __DIR__ . '/../Modelo/Materia.php';

use Modelo\Conexion;
use Modelo\Estudiante;
use Modelo\program;
use Modelo\subject;
use Modelo\Nota;

$db     = (new Conexion())->getConexion();
$E  = count(Estudiante::getAll($db));
$P  = count(program::getAll($db));
$M  = count(subject::getAll($db));
?>

<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Dashboard</title>
</head>
<body>

<h1>Panel principal</h1>

<p>Estudiantes registrados: <?= $E ?></p>
<p>Materias registrados: <?= $M ?></p>
<p>Programas registrados: <?= $P ?></p>


<form action="../Controlador/EstudianteController.php" method="pos">
    <button type="submit">Ver todos los estudiantes</button>
</form>
<form action="../Vista/estudiantes_list.php" method="pos">
    <button type="submit">Crear estudiantes</button>
</form>

<form action="../controlador/MateriaController.php" method="post">
    <button type="submit">Ver todos las materias</button>
</form>

<form action="../Controlador/ProgramaController.php" method="post">
    <button type="submit">Ver todos los programas </button>
</form>

</body>
</html>
