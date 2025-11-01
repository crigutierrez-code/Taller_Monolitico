<?php

require_once __DIR__ . '/../../Controlador/EstudianteController.php';
use Controllers\EstudiantesController;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $controller = new EstudiantesController();
    $exito = $controller->guardar($_POST);

    header("Location: ../estudiantes_list.php?creado=" . ($exito ? '1' : '0'));
    exit;
} else {

    header("Location: ../estudiantes_form.php");
    exit;
}
?>