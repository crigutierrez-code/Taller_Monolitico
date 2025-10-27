<?php
require_once __DIR__ . '/Modelo/Conexion.php';
require_once __DIR__ . '/Modelo/estudiante.php';

use Modelo\Conexion;
use Modelo\estudiante;

try {
    $db = (new Conexion())->getConexion();
} catch (Exception $e) {
    die('DB error: ' . $e->getMessage());
}

/* ---------- búsqueda ---------- */
$search = $_GET['search'] ?? '';
if ($search === '') {
    $students = estudent::getAll($db);
}
