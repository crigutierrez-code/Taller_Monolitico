<?php
require_once __DIR__ . '/../../Controlador/MateriaController.php';
use Controllers\MateriasController;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['codigo'])) {
    $controller = new MateriasController();
    $exito = $controller->eliminar($_POST['codigo']);

    header("Location: ../materias_list.php?eliminado=" . ($exito ? '1' : '0'));
    exit;
} else {
    header("Location: ../materias_list.php");
    exit;
}
?>