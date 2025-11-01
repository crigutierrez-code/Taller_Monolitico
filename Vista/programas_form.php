<?php
require_once __DIR__ . '/../Controlador/ProgramaController.php';

use Controllers\ProgramasController;

$controller = new ProgramasController();

$codigo = $_GET['cod'] ?? null;
$programa = null;

if ($codigo) {
    // --- MODO EDITAR ---
    $titulo = "Modificar Programa";
    $action = "operaciones/actualizar_programa.php";


    $programa = $controller->editar($codigo);

    if (!$programa) {
        header("Location: programas_list.php");
        exit;
    }
} else {

    $titulo = "Nuevo Programa";
    $action = "operaciones/crear_programa.php";
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $titulo; ?></title>
    <link rel="stylesheet" href="../Public/css/estilos.css">
</head>

<body>
    <h1><?php echo $titulo; ?></h1>
    <div class="container-form"> <a href="estudiantes_list.php" class="btn-cancelar">Volver a la lista</a>

        <form action="<?php echo $action; ?>" method="POST">

            <?php if ($programa): ?>
                <input type="hidden" name="codigo" value="<?php echo $programa->getCodigo(); ?>">
            <?php endif; ?>

            <div>
                <label for="codigo">Código:</label>
                <input
                    type="text"
                    name="codigo"
                    id="codigo"
                    value="<?php echo $programa ? $programa->getCodigo() : ''; ?>"
                    <?php echo $programa ? 'readonly' : 'required'; ?>>
            </div>
            <div>
                <label for="nombre">Nombre:</label>
                <input
                    type="text"
                    name="nombre"
                    id="nombre"
                    value="<?php echo $programa ? $programa->getNombre() : ''; ?>"
                    required>
            </div>

            <button type="submit">Guardar</button>
        </form>
    </div>
</body>

</html>