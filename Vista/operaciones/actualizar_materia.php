<?php

require_once __DIR__ . '/../../Controlador/MateriaController.php';
use Controllers\MateriasController;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $controller = new MateriasController();
    $exito = $controller->actualizar($_POST);

    if ($exito) {
        header("Location: ../materias_list.php?actualizado=1");
    } else {
        header("Location: ../materias_form.php?cod=" . $_POST['codigo'] . "&error=1");
    }
    exit;
} else {
    header("Location: ../materias_list.php");
    exit;
}
?>