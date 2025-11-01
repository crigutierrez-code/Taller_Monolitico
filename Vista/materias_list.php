<?php
require_once __DIR__ . '/../Modelo/Conexion.php';
require_once __DIR__ . '/../Modelo/Materia.php';

use Modelo\Conexion;
use Modelo\Estudiante;

$db = (new Conexion())->getConexion();



?>

/--------------------/
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Crear Estudiante</title>
</head>
<body>

<h1>Nueva materia</h1>

<form action="../Modelo/Funciones/materias_crear .php" method="post">

    <label>Código único
        <input type="text" name="codigo" required>
    </label>

    <label>Materia
        <input type="text" name="nombre" required>
    </label>

    <label>Programa
        <select name="programa" required>
            <option value="1111" selected>Ing. Sistemas</option>
            <option value="2222"selected>Ing. Multimedia</option>
        </select>
    </label>

    <button type="submit">Guardar estudiante</button>
    <a href="../Vista/dashboard.php">volver</a>
</form>
</body>
</html>