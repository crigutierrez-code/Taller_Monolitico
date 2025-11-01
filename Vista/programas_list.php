<?php
require_once __DIR__ . '/../Controlador/ProgramaController.php';
use Controllers\ProgramasController;

$controller = new ProgramasController();
$programas = $controller->listar(); 
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Programas</title>
    <link rel="stylesheet" href="../Public/css/estilos.css">
    <link rel="stylesheet" href="../Public/css/modal.css">
</head>
<body>
    <h1>Programas Registrados</h1>
    <a class="btn-cancelar" href="dashboard.php">Volver al Dashboard</a>
    <a class="btn-crear" href="programas_form.php">Crear Nuevo Programa</a>

    <table>
        <thead>
            <tr>
                <th>Código</th>
                <th>Nombre</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php if (count($programas) > 0): ?>
                <?php foreach ($programas as $prog): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($prog['codigo']); ?></td>
                        <td><?php echo htmlspecialchars($prog['nombre']); ?></td>
                        <td class="acciones">
                            <a href="programas_form.php?cod=<?php echo $prog['codigo']; ?>" class="btn-editar">Editar</a>
                            <button onclick="abrirModalEliminar('<?php echo $prog['codigo']; ?>')" class="btn-eliminar">Eliminar</button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="3">No hay programas registrados.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <div id="modalConfirmacion" class="modal">
        <div class="modal-contenido">
            <span class="cerrar" onclick="cerrarModalEliminar()">&times;</span>
            <h2>Confirmar Eliminación</h2>
            <p>¿Estás seguro de que deseas eliminar este Programa?</p>
            <p>NOTA: Solo se puede eliminar si NO tiene estudiantes o materias relacionadas.</p>
            <form id="formEliminar" action="operaciones/eliminar_programa.php" method="POST">
                <input type="hidden" name="codigo" id="codigoEliminar">
                <button type="button" onclick="cerrarModalEliminar()" class="btn-cancelar">Cancelar</button>
                <button type="submit" class="btn-eliminar">Confirmar Eliminación</button>
            </form>
        </div>
    </div>
    <script src="../Public/js/modal.js"></script>
</body>
</html>