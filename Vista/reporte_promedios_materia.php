<?php
require_once __DIR__ . '/../Controlador/NotaController.php';

use Controllers\NotasController;

$controller = new NotasController();
$promedios = $controller->listarPromediosPorMateriaYEstudiante();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Promedios por Materia y Estudiante</title>
    <link rel="stylesheet" href="../Public/css/estilos.css">
</head>
<body>
    <div class="container">
        <h1>Promedios de Notas por Materia</h1>
        <a href="dashboard.php" class="btn-cancelar">Volver al Dashboard</a>

        <table>
            <thead>
                <tr>
                    <th>Materia</th>
                    <th>Estudiante</th>
                    <th>Promedio Final</th>
                    <th>Detalle</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($promedios as $p): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($p['nombre_materia']); ?></td>
                        <td><?php echo htmlspecialchars($p['nombre_estudiante']); ?></td>
                        <td><?php echo htmlspecialchars($p['promedio']); ?></td>
                        <td>
                            <a href="reporte_detalle_notas.php?mat=<?php echo $p['codigo_materia']; ?>&est=<?php echo $p['codigo_estudiante']; ?>" class="btn-editar">Ver Detalle</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>