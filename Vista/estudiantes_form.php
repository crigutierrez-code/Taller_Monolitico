<?php
require_once __DIR__ . '/../Controlador/EstudianteController.php';

use Controllers\EstudiantesController;

$controller = new EstudiantesController();

$codigo = $_GET['cod'] ?? null;
$estudiante = null;
$programas = [];

if ($codigo) {
    $titulo = "Modificar Estudiante";
    $action = "operaciones/actualizar_estudiante.php";

    $datos = $controller->editar($codigo);
    $estudiante = $datos['estudiante'];
    $programas = $datos['programas'];

    if (!$estudiante) {
        header("Location: estudiantes_list.php");
        exit;
    }
} else {
    $titulo = "Nuevo Estudiante";
    $action = "operaciones/crear_estudiante.php";
    $programas = $controller->crear();
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
    <a href="estudiantes_list.php">Volver a la lista</a>

    <form action="<?php echo $action; ?>" method="POST">

        <?php if ($estudiante): ?>
            <input type="hidden" name="codigo" value="<?php echo $estudiante->getCodigo(); ?>">
        <?php endif; ?>

        <div>
            <label for="codigo">Código:</label>
            <input
                type="text"
                name="codigo"
                id="codigo"
                value="<?php echo $estudiante ? $estudiante->getCodigo() : ''; ?>"
                <?php echo $estudiante ? 'readonly' : 'required'; ?>>
        </div>
        <div>
            <label for="nombre">Nombre:</label>
            <input
                type="text"
                name="nombre"
                id="nombre"
                value="<?php echo $estudiante ? $estudiante->getNombre() : ''; ?>"
                required>
        </div>
        <div>
            <label for="email">Email:</label>
            <input
                type="email"
                name="email"
                id="email"
                value="<?php echo $estudiante ? $estudiante->getEmail() : ''; ?>"
                required>
        </div>
        <div>
            <label for="programa">Programa:</label>
            <select name="programa" id="programa" required>
                <option value="">Seleccione un programa...</option>
                <?php foreach ($programas as $prog): ?>
                    <option
                        value="<?php echo $prog['codigo']; ?>"
                        <?php echo ($estudiante && $estudiante->getPrograma() == $prog['codigo']) ? 'selected' : ''; ?>>
                        <?php echo htmlspecialchars($prog['nombre']); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <button type="submit">Guardar</button>
    </form>
</body>

</html>