<?php
require_once __DIR__ . '/../Controlador/NotaController.php';
require_once __DIR__ . '/../Modelo/Estudiante.php';
require_once __DIR__ . '/../Modelo/Materia.php';
require_once __DIR__ . '/../Modelo/Conexion.php';

use Controllers\NotasController;
use Modelo\Estudiante;
use Modelo\Materia;
use Modelo\Conexion;

$db = (new Conexion())->getConexion();
$controller = new NotasController();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Acepta tanto POST como GET
$materia_cod = $_POST['materia'] ?? $_GET['mat'] ?? '';
$estudiante_cod = $_POST['estudiante'] ?? $_GET['est'] ?? '';

// Si no vienen datos, redirige
if (empty($materia_cod) || empty($estudiante_cod)) {
    header("Location: dashboard.php");
    exit;
}

// Llama al método que obtiene las notas
$detalles = $controller->listarNotasDetallePorEstudianteYMateria($materia_cod, $estudiante_cod);

// Obtiene los nombres de estudiante y materia
$estudiante_info = Estudiante::getByCodigo($db, $estudiante_cod);
$materia_info = Materia::getByCodigo($db, $materia_cod);

// Acceso como objeto
$nombre_estudiante = $estudiante_info ? $estudiante_info->getNombre() : 'Estudiante Desconocido';
$nombre_materia = $materia_info ? $materia_info->getNombre() : 'Materia Desconocida';

?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Detalle de Notas</title>
    <link rel="stylesheet" href="../Public/css/estilos.css">
</head>

<body>
    <div class="container">
        <h1>Notas Detalladas</h1>
        <h2><?php echo htmlspecialchars($nombre_estudiante); ?> en <?php echo htmlspecialchars($nombre_materia); ?></h2>
        <a href="reporte_promedios_estudiante.php" class="btn-cancelar">Volver a Reportes</a>

        <table>
            <thead>
                <tr>
                    <th>Actividad</th>
                    <th>Nota</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($detalles)): ?>
                    <?php foreach ($detalles as $d): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($d['actividad']); ?></td>
                            <td><?php echo htmlspecialchars($d['nota']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="2">No hay notas registradas para esta combinación.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</body>

</html>