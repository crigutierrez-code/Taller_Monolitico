<?php

require_once __DIR__ . '/../../Controlador/ProgramaController.php';
use Controllers\ProgramasController;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $controller = new ProgramasController();
    $exito = $controller->actualizar($_POST);

    if ($exito) {
        header("Location: ../programas_list.php?actualizado=1");
    } else {

        header("Location: ../programas_form.php?cod=" . $_POST['codigo'] . "&error=1");
    }
    exit;
} else {
    header("Location: ../programas_list.php");
    exit;
}
?>