<?php
require_once __DIR__ . '/../Modelo/Conexion.php';
require_once __DIR__ . '/../Modelo/Programa.php';

use Modelo\Conexion;
use Modelo\Programa;

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

<h1>Nuevo estudiante</h1>

<form action="../Modelo/Funciones/programa_crear.php" method="post">

    <label>Código único
        <input type="text" name="codigo" required>
    </label>

    <label>Nombre completo
        <input type="text" name="nombre" required>
    </label>

    <button type="submit">Guardar estudiante</button>
    <a href="../Vista/dashboard.php">volver</a>
</form>
</body>
</html>