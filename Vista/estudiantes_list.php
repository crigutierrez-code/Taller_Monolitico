<?php
require_once __DIR__ . '/../Controlador/EstudianteController.php';

use Controllers\EstudiantesController;

$controller = new EstudiantesController();
$estudiantes = $controller->listar();
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Estudiantes</title>
    <link rel="stylesheet" href="../Public/css/estilos.css">
    <link rel="stylesheet" href="../Public/css/modal.css">
</head>

<body>
    <h1>Estudiantes Registrados</h1>
    <a class="btn-cancelar" href="dashboard.php">Volver al Dashboard</a>
    <a class="btn-crear" href="estudiantes_form.php">Crear Nuevo Estudiante</a>

    <table>
        <thead>
            <tr>
                <th>Código</th>
                <th>Nombre</th>
                <th>Email</th>
                <th>Programa</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php if (count($estudiantes) > 0): ?>
                <?php foreach ($estudiantes as $est): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($est['codigo']); ?></td>
                        <td><?php echo htmlspecialchars($est['nombre']); ?></td>
                        <td><?php echo htmlspecialchars($est['email']); ?></td>
                        <td><?php echo htmlspecialchars($est['programa_nombre']); ?></td>
                        <td class="acciones">
                            <a href="estudiantes_form.php?cod=<?php echo $est['codigo']; ?>" class="btn-editar">Editar</a>

                            <button onclick="abrirModalEliminar('<?php echo $est['codigo']; ?>')" class="btn-eliminar">Eliminar</button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="5">No hay estudiantes registrados.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <div id="modalConfirmacion" class="modal">
        <div class="modal-contenido">
            <span class="cerrar" onclick="cerrarModalEliminar()">&times;</span>
            <h2>Confirmar Eliminación</h2>
            <p>¿Estás seguro de que deseas eliminar este registro?</p>
            <p>Esta acción no se puede deshacer.</p>

            <form id="formEliminar" action="operaciones/eliminar_estudiante.php" method="POST">
                <input type="hidden" name="codigo" id="codigoEliminar">
                <button type="button" onclick="cerrarModalEliminar()" class="btn-cancelar">Cancelar</button>
                <button type="submit" class="btn-eliminar">Confirmar Eliminación</button>
            </form>
        </div>
    </div>
    <script src="../Public/js/modal.js"></script>
</body>

</html>
