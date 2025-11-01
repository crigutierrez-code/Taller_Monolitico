<?php

require_once __DIR__ . '/../../Controlador/NotaController.php';
use Controllers\NotasController;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $controller = new NotasController();

    $exito = $controller->actualizar($_POST);

    if ($exito) {
        header("Location: ../notas_list.php?actualizado=1");
    } else {
        header("Location: ../notas_form.php?mat=" . $_POST['materia'] . "&est=" . $_POST['estudiante'] . "&act=" . urlencode($_POST['actividad']) . "&error=1");
    }
    exit;
} else {
    header("Location: ../notas_list.php");
    exit;
}
?>