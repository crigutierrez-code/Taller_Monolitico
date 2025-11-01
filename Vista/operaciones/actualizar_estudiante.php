<?php

require_once __DIR__ . '/../../Controlador/EstudianteController.php';
use Controllers\EstudiantesController;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $controller = new EstudiantesController();
    $exito = $controller->actualizar($_POST);

    if ($exito) {
        header("Location: ../estudiantes_list.php?actualizado=1");
    } else {
        header("Location: ../estudiantes_form.php?cod=" . $_POST['codigo'] . "&error=1");
    }
    exit;
} else {
    header("Location: ../estudiantes_list.php");
    exit;
}
?>