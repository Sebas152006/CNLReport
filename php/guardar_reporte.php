<?php

session_start();

require 'conexion_be.php'; // Asegura que la conexión está bien importada

// Validar que el usuario está autenticado
if (!isset($_SESSION['id'])) {
    die("Error: Usuario no autenticado.");
}
$usuario_id = $_SESSION['id']; 
$piso = $_POST['piso'];
$habitacion = $_POST['habitacion'];
$tipo_dano = $_POST['tipo_dano'];
$reporte = $_POST['reporte'];

// Validar que el usuario existe en la base de datos
$query_usuario = "SELECT id FROM usuarios WHERE id = ?";
$stmt_usuario = $conexion->prepare($query_usuario);
$stmt_usuario->bind_param("i", $usuario_id);
$stmt_usuario->execute();
$resultado_usuario = $stmt_usuario->get_result();

if ($resultado_usuario->num_rows == 0) {
    die("Error: El usuario no existe en la base de datos.");
}

// Insertar el reporte en la tabla `reportes`
$query = "INSERT INTO reportes (usuario_id, piso, habitacion, reporte, tipo_dano, estado) VALUES (?, ?, ?, ?, ?, 'Ingresada')";
$stmt = $conexion->prepare($query);
$stmt->bind_param("iisss", $usuario_id, $piso, $habitacion, $reporte, $tipo_dano);

if ($stmt->execute()) {
    // Verificar el rol del usuario
    $rol = $_SESSION['rol'] ?? null;

    if ($rol == 1) {
        header("Location: ../roles/administrador_reportes/reporte_Timbres.php");
    } else {
        header("Location: ../roles/usuarios_reportes/reporte_Timbres.php");
    }
    exit;
} else {
    die("Error al guardar el reporte: " . $stmt->error);
}

$stmt->close();
?>
