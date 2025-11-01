<?php
require_once __DIR__ . '/../../Controlador/ProgramaController.php';
use Controllers\ProgramasController;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['codigo'])) {
    $controller = new ProgramasController();
    $exito = $controller->eliminar($_POST['codigo']);

    header("Location: ../programas_list.php?eliminado=" . ($exito ? '1' : '0'));
    exit;
} else {
    header("Location: ../programas_list.php");
    exit;
}
?>