<?php
require_once __DIR__ . '/../../Controlador/ProgramaController.php';
use Controllers\ProgramasController;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $controller = new ProgramasController();
    $exito = $controller->guardar($_POST);

    header("Location: ../programas_list.php?creado=" . ($exito ? '1' : '0'));
    exit;
} else {
    header("Location: ../programas_form.php");
    exit;
}
?>