<?php
require_once __DIR__ . '/../../Controlador/NotaController.php';
use Controllers\NotasController;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (empty($_POST['materia']) || empty($_POST['estudiante']) || empty($_POST['actividad'])) {
         header("Location: ../notas_list.php?eliminado=0");
         exit;
    }

    $controller = new NotasController();
    $exito = $controller->eliminar($_POST['materia'], $_POST['estudiante'], $_POST['actividad']);

    header("Location: ../notas_list.php?eliminado=" . ($exito ? '1' : '0'));
    exit;
} else {
    header("Location: ../notas_list.php");
    exit;
}
?>