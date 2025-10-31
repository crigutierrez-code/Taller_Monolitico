<?php
require_once __DIR__ . '/../Modelo/Conexion.php';
require_once __DIR__ . '/../Modelo/Estudiante.php';

use Modelo\Conexion;
use Modelo\Estudiante;

$db = (new Conexion())->getConexion();

?>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Crear estudiante</title>
</head>
<body>

<h1>Nuevo estudiante</h1>

<form action="../Modelo/Funciones/estudiante_crear.php" method="post"></form>
    <label>Código:<br>
        <input type="text" name="codigo" required>
    </label><br>

    <label>Nombre:<br>
        <input type="text" name="nombre" required>
    </label><br>

    <label>Email:<br>
        <input type="email" name="email" required>
    </label><br>

    <label>Programa:<br>
        <input type="text" name="programa" required>
    </label><br>

    <button type="submit">Crear estudiante</button>
    <a href="../Vista/dashboard.php">Cancelar</a>
</form>

</body>
</html>