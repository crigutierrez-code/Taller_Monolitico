<?php

require_once __DIR__ . '/../../Controlador/EstudianteController.php';
use Controllers\EstudiantesController;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['codigo'])) {
    $controller = new EstudiantesController();
    $exito = $controller->eliminar($_POST['codigo']);

    header("Location: ../estudiantes_list.php?eliminado=" . ($exito ? '1' : '0'));
    exit;
} else {
    header("Location: ../estudiantes_list.php");
    exit;
}
?>