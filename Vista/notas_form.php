<?php
require_once __DIR__ . '/../Controlador/NotaController.php';
require_once __DIR__ . '/../Modelo/Estudiante.php'; 
require_once __DIR__ . '/../Modelo/Materia.php';

use Controllers\NotasController;

$controller = new NotasController();

// Clave compuesta para edición
$materia_cod = $_GET['mat'] ?? null;
$estudiante_cod = $_GET['est'] ?? null;
$actividad_name = $_GET['act'] ?? null;

$nota = null;


$datos = $controller->crear();
$estudiantes = $datos['estudiantes'];
$materias = $datos['materias'];


if ($materia_cod && $estudiante_cod && $actividad_name) {

    $titulo = "Modificar Nota";
    $action = "operaciones/actualizar_nota.php";

    $nota = $controller->editar($materia_cod, $estudiante_cod, $actividad_name);

    if (!$nota) {
        header("Location: notas_list.php");
        exit;
    }
} else {
    $titulo = "Registrar Nueva Nota";
    $action = "operaciones/crear_nota.php";
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

            <?php if ($nota): ?>
                <input type="hidden" name="materia_original" value="<?php echo htmlspecialchars($nota['materia']); ?>">
                <input type="hidden" name="estudiante_original" value="<?php echo htmlspecialchars($nota['estudiante']); ?>">
                <input type="hidden" name="actividad_original" value="<?php echo htmlspecialchars($nota['actividad']); ?>">
            <?php endif; ?>

            <div>
                <label for="estudiante">Estudiante:</label>
                <select name="estudiante" id="estudiante" <?php echo $nota ? 'readonly' : 'required'; ?>>
                    <option value="">Seleccione un estudiante...</option>
                    <?php foreach ($estudiantes as $est): ?>
                        <option
                            value="<?php echo $est['codigo']; ?>"
                            <?php echo ($nota && $nota['estudiante'] == $est['codigo']) ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($est['nombre'] . ' (' . $est['codigo'] . ')'); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div>
                <label for="materia">Materia:</label>
                <select name="materia" id="materia" <?php echo $nota ? 'readonly' : 'required'; ?>>
                    <option value="">Seleccione una materia...</option>
                    <?php foreach ($materias as $mat): ?>
                        <option
                            value="<?php echo $mat['codigo']; ?>"
                            <?php echo ($nota && $nota['materia'] == $mat['codigo']) ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($mat['nombre'] . ' (' . $mat['codigo'] . ')'); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div>
                <label for="actividad">Actividad (Ej: Parcial 1):</label>
                <input
                    type="text"
                    name="actividad"
                    id="actividad"
                    value="<?php echo $nota ? htmlspecialchars($nota['actividad']) : ''; ?>"
                    <?php echo $nota ? 'readonly' : 'required'; ?>>
            </div>

            <div>
                <label for="nota">Nota (0.0 a 5.0):</label>
                <input
                    type="number"
                    name="nota"
                    id="nota"
                    value="<?php echo $nota ? htmlspecialchars($nota['nota']) : ''; ?>"
                    step="0.01"
                    min="0.0"
                    max="5.0"
                    required>
            </div>

            <button type="submit">Guardar Nota</button>
        </form>
    </div>
</body>

</html>