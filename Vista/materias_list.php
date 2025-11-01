<?php

require_once __DIR__ . '/../Controlador/MateriaController.php';
use Controllers\MateriasController;

$controller = new MateriasController();

$materias = $controller->listar(); 
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Materias</title>
    <link rel="stylesheet" href="../Public/css/estilos.css">
    <link rel="stylesheet" href="../Public/css/modal.css">
</head>
<body>
    <h1>Materias Registradas</h1>
    <a class="btn-cancelar" href="dashboard.php">Volver al Dashboard</a>
    <a class="btn-crear" href="materias_form.php">Crear Nueva Materia</a>

    <table>
        <thead>
            <tr>
                <th>Código</th>
                <th>Nombre</th>
                <th>Programa (Cód.)</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php if (count($materias) > 0): ?>
                <?php foreach ($materias as $mat): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($mat['codigo']); ?></td>
                        <td><?php echo htmlspecialchars($mat['nombre']); ?></td>
                        <td><?php echo htmlspecialchars($mat['programa']); ?></td>
                        <td class="acciones">
                            <a href="materias_form.php?cod=<?php echo $mat['codigo']; ?>" class="btn-editar">Editar</a>
                            <button onclick="abrirModalEliminar('<?php echo $mat['codigo']; ?>')" class="btn-eliminar">Eliminar</button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="4">No hay materias registradas.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <div id="modalConfirmacion" class="modal">
        <div class="modal-contenido">
            <span class="cerrar" onclick="cerrarModalEliminar()">&times;</span>
            <h2>Confirmar Eliminación</h2>
            <p>¿Estás seguro de que deseas eliminar esta Materia?</p>
            <p>NOTA: Solo se puede eliminar si NO tiene notas registradas.</p>

            <form id="formEliminar" action="operaciones/eliminar_materia.php" method="POST">
                <input type="hidden" name="codigo" id="codigoEliminar">
                <button type="button" onclick="cerrarModalEliminar()" class="btn-cancelar">Cancelar</button>
                <button type="submit" class="btn-eliminar">Confirmar Eliminación</button>
            </form>
        </div>
    </div>
    <script src="../Public/js/modal.js"></script>
</body>
</html>