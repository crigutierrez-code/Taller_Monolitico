<?php
    $host = "localhost";
    $user = "root";
    $pass = "";
    $db = "notas_app";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $cod  = $_POST['codigo']   ?? '';
    $nom  = $_POST['nombre']   ?? '';
    $mail = $_POST['email']    ?? '';
    $prog = $_POST['programa'] ?? '';

    $sql  = "INSERT INTO estudiantes (codigo, nombre, email, programa) VALUES (?,?,?,?)";
    $stmt = $conexDb->prepare($sql);
    $stmt->bind_param('ssss', $cod, $nom, $mail, $prog);

    if ($stmt->execute()) {
        header("Location: ../Vista/dashboard.php?ok=1");
        exit;
    } else {
        header("Location: ../Vista/crear_estudiante.html?error=1");
        exit;
    }
} else {
    // Acceso directo prohibido
    header("Location: ../Vista/crear_estudiante.html");
    exit;
}
?>