<?php
require_once __DIR__ . '/../Modelo/Conexion.php';
require_once __DIR__ . '/../Modelo/Estudiante.php';
require_once __DIR__ . '/../Modelo/Programa.php';
require_once __DIR__ . '/../Modelo/Materia.php';

use Modelo\Conexion;
use Modelo\Estudiante;
use Modelo\Programa;
use Modelo\Materia;

$db = (new Conexion())->getConexion();
$totalEstudiantes = count(Estudiante::getAll($db));
$totalProgramas = count(Programa::getAll($db));
$totalMaterias = count(Materia::getAll($db));
?>

<!doctype html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <title>Dashboard</title>
    <link rel="stylesheet" href="../Public/css/estilos.css">
</head>

<body>
    <div class="container">
        <h1>Panel principal</h1>

        <p>Estudiantes registrados: <?= $totalEstudiantes ?></p>
        <p>Materias registrados: <?= $totalMaterias ?></p>
        <p>Programas registrados: <?= $totalProgramas ?></p>

        <h2>Gestión de Entidades</h2>

        <h3>Estudiantes</h3>
        <a href="estudiantes_list.php" class="btn-lista btn-dashboard">Ver Lista de Estudiantes</a>
        <a href="estudiantes_form.php" class="btn-crear btn-dashboard">Crear Nuevo Estudiante</a>

        <h3>Materias</h3>
        <a href="materias_list.php" class="btn-lista btn-dashboard">Ver Lista de Materias</a>
        <a href="materias_form.php" class="btn-crear btn-dashboard">Crear Nueva Materia</a>

        <h3>Programas</h3>
        <a href="programas_list.php" class="btn-lista btn-dashboard">Ver Lista de Programas</a>
        <a href="programas_form.php" class="btn-crear btn-dashboard">Crear Nuevo Programa</a>

        <h3>Notas</h3>
        <a href="notas_list.php" class="btn-lista btn-dashboard">Ver Lista de Notas</a>
        <a href="notas_form.php" class="btn-crear btn-dashboard">Registrar Nueva Nota</a>
    </div>
</body>

</html>