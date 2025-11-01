<?php
// Conexión
$conexion = new mysqli("localhost", "root", "", "notas_app");

// Recibir datos
$codigo = trim($_POST['codigo'] ?? '');
$nombre = trim($_POST['nombre'] ?? '');
$programa = trim($_POST['programa'] ?? '');

// Validar
if (empty($codigo) || empty($nombre) || empty($programa)) {
    header("Location: ../../Vista/estudiantes_form.php?error=campos_vacios");
    exit;
}

// Verificar duplicado
$check = $conexion->prepare("SELECT codigo FROM materias WHERE codigo = ?");
$check->bind_param("s", $codigo);
$check->execute();
$check->store_result();
if ($check->num_rows > 0) {
    header("Location: ../../Vista/estudiantes_form.php?error=estudiante_existe");
    exit;
}
$check->close();

// Insertar
$stmt = $conexion->prepare("INSERT INTO materias (codigo, nombre, programa) 
VALUES (?, ?, ?)");
$stmt->bind_param("sss", $codigo, $nombre, $programa);

if ($stmt->execute()) {
    header("Location: ../../Vista/dashboard.php");
} else {
    header("Location: ../../Vista/estudiantes_form.php?error=creacion_fallida");
}

$stmt->close();
$conexion->close();
exit;
?>