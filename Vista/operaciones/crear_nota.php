<?php
require_once __DIR__ . '/../../Controlador/NotaController.php';
use Controllers\NotasController;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $controller = new NotasController();
    $exito = $controller->guardar($_POST);

    header("Location: ../notas_list.php?creado=" . ($exito ? '1' : '0'));
    exit;
} else {
    header("Location: ../notas_form.php");
    exit;
}
?>