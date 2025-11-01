<?php
require_once __DIR__ . '/../Controlador/NotaController.php';
use Controllers\NotasController;

$controller = new NotasController();
$notas_detalle = $controller->listarDetalle(); 
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista Detallada de Notas</title>
    <link rel="stylesheet" href="../Public/css/estilos.css">
    <link rel="stylesheet" href="../Public/css/modal.css">
</head>
<body>
    <h1>Registro de Notas Detallado</h1>
    <a href="dashboard.php">Volver al Dashboard</a>
    <a href="notas_form.php">Registrar Nueva Nota</a>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Estudiante</th>
                <th>Materia</th>
                <th>Actividad</th>
                <th>Nota</th>
                <th>Fecha Reg.</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php if (count($notas_detalle) > 0): ?>
                <?php foreach ($notas_detalle as $n): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($n['id']); ?></td>
                        <td><?php echo htmlspecialchars($n['nombre_estudiante'] . ' (' . $n['estudiante'] . ')'); ?></td>
                        <td><?php echo htmlspecialchars($n['nombre_materia'] . ' (' . $n['materia'] . ')'); ?></td>
                        <td><?php echo htmlspecialchars($n['actividad']); ?></td>
                        <td><?php echo htmlspecialchars($n['nota']); ?></td>
                        <td><?php echo htmlspecialchars($n['fecha_registro']); ?></td>
                        <td class="acciones">
                            <a href="notas_form.php?mat=<?php echo $n['materia']; ?>&est=<?php echo $n['estudiante']; ?>&act=<?php echo urlencode($n['actividad']); ?>" class="btn-editar">Editar</a>

                            <button 
                                onclick="abrirModalEliminarNota('<?php echo $n['materia']; ?>', '<?php echo $n['estudiante']; ?>', '<?php echo $n['actividad']; ?>')" 
                                class="btn-eliminar"
                            >
                                Eliminar
                            </button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="7">No hay notas registradas.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <div id="modalConfirmacionNota" class="modal">
        <div class="modal-contenido">
            <span class="cerrar" onclick="cerrarModalEliminarNota()">&times;</span>
            <h2>Confirmar Eliminación de Nota</h2>
            <p>¿Estás seguro de que deseas eliminar este registro de nota?</p>
            <form id="formEliminarNota" action="operaciones/eliminar_nota.php" method="POST">
                <input type="hidden" name="materia" id="materiaEliminar">
                <input type="hidden" name="estudiante" id="estudianteEliminar">
                <input type="hidden" name="actividad" id="actividadEliminar">
                <button type="button" onclick="cerrarModalEliminarNota()" class="btn-cancelar">Cancelar</button>
                <button type="submit" class="btn-eliminar">Confirmar Eliminación</button>
            </form>
        </div>
    </div>
    
    <script>
        var modalNota = document.getElementById("modalConfirmacionNota");

        function abrirModalEliminarNota(materia, estudiante, actividad) {
            document.getElementById("materiaEliminar").value = materia;
            document.getElementById("estudianteEliminar").value = estudiante;
            document.getElementById("actividadEliminar").value = actividad;
            modalNota.style.display = "block";
        }

        function cerrarModalEliminarNota() {
            modalNota.style.display = "none";
        }

        window.onclick = function(event) {
            if (event.target == modalNota) {
                cerrarModalEliminarNota();
            }
        }
    </script>
    <script src="../Public/js/modal.js"></script> 
</body>
</html>