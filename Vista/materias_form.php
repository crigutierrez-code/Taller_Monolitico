<?php
// TALLER_MONOLITICO/Vista/materias_form.php
require_once __DIR__ . '/../Controlador/MateriaController.php';

use Controllers\MateriasController;

$controller = new MateriasController();

$codigo = $_GET['cod'] ?? null;
$materia = null;
$programas = [];

if ($codigo) {

    $titulo = "Modificar Materia";
    $action = "operaciones/actualizar_materia.php";

    $datos = $controller->editar($codigo);
    $materia = $datos['materia'];
    $programas = $datos['programas'];

    if (!$materia) {
        header("Location: materias_list.php");
        exit;
    }
} else {

    $titulo = "Nueva Materia";
    $action = "operaciones/crear_materia.php";

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
    <div class="container-form"> <a href="estudiantes_list.php" class="btn-cancelar">Volver a la lista</a>

        <form action="<?php echo $action; ?>" method="POST">

            <?php if ($materia): ?>
                <input type="hidden" name="codigo" value="<?php echo $materia->getCodigo(); ?>">
            <?php endif; ?>

            <div>
                <label for="codigo">Código:</label>
                <input
                    type="text"
                    name="codigo"
                    id="codigo"
                    value="<?php echo $materia ? $materia->getCodigo() : ''; ?>"
                    <?php echo $materia ? 'readonly' : 'required'; ?>>
            </div>
            <div>
                <label for="nombre">Nombre:</label>
                <input
                    type="text"
                    name="nombre"
                    id="nombre"
                    value="<?php echo $materia ? $materia->getNombre() : ''; ?>"
                    required>
            </div>
            <div>
                <label for="programa">Programa:</label>
                <select name="programa" id="programa" required>
                    <option value="">Seleccione un programa...</option>
                    <?php foreach ($programas as $prog): ?>
                        <option
                            value="<?php echo $prog['codigo']; ?>"
                            <?php echo ($materia && $materia->getPrograma() == $prog['codigo']) ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($prog['nombre']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <button type="submit">Guardar</button>
        </form>
    </div>
</body>

</html>