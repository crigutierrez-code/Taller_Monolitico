<?php

require_once __DIR__ . '/../Controlador/NotaController.php';

use Controllers\NotasController;

$controller = new NotasController();
$promedios = $controller->listarPromediosPorMateriaYEstudiante(); // Usa la misma función
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Promedios de Materias por Estudiante</title>
    <link rel="stylesheet" href="../Public/css/estilos.css">
</head>

<body>
    <div class="container">
        <h1>Promedios de Notas por Estudiante</h1>
        <a href="dashboard.php" class="btn-cancelar">Volver al Dashboard</a>

        <table>
            <thead>
                <tr>
                    <th>Estudiante</th>
                    <th>Materia</th>
                    <th>Promedio Final</th>
                    <th>Detalle</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $estudiante_actual = '';
                foreach ($promedios as $p):
                    // Se puede mejorar visualmente agrupando el nombre del estudiante
                    if ($estudiante_actual != $p['codigo_estudiante']) {
                        echo '<tr><td colspan="4" style="background-color:#eee; font-weight:bold; text-align:center;">' . htmlspecialchars($p['nombre_estudiante']) . '</td></tr>';
                        $estudiante_actual = $p['codigo_estudiante'];
                    }
                ?>
                    <tr>
                        <td></td>
                        <td><?php echo htmlspecialchars($p['nombre_materia']); ?></td>
                        <td><?php echo htmlspecialchars($p['promedio']); ?></td>
                        <td>
                            <a href="reporte_detalle_notas.php?mat=<?php echo $p['codigo_materia']; ?>&est=<?php echo $p['codigo_estudiante']; ?>" class="btn-editar">Ver Detalle</a>

                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>

</html>