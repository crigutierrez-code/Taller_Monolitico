<?php

require_once __DIR__ . '/../../Controlador/MateriaController.php';
use Controllers\MateriasController;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $controller = new MateriasController();
    $exito = $controller->guardar($_POST);

    header("Location: ../materias_list.php?creado=" . ($exito ? '1' : '0'));
    exit;
} else {
    header("Location: ../materias_form.php");
    exit;
}
?>