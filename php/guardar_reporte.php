<?php
session_start();
require 'conexion_be.php'; 

// Validar sesión
if (!isset($_SESSION['id'])) {
    die("Error: Usuario no autenticado.");
}
$usuario_id = $_SESSION['id'];

// Datos del form
$piso       = $_POST['piso'];
$habitacion = $_POST['habitacion']; // llega el id
$tipo_dano  = $_POST['tipo_dano'];
$reporte    = $_POST['reporte'];

// Validar usuario
$query_usuario = "SELECT id FROM usuarios WHERE id = ?";
$stmt_usuario = $conexion->prepare($query_usuario);
$stmt_usuario->bind_param("i", $usuario_id);
$stmt_usuario->execute();
$resultado_usuario = $stmt_usuario->get_result();
if ($resultado_usuario->num_rows == 0) {
    die("Error: El usuario no existe en la base de datos.");
}

// Traducir ID de piso → número real
$query_piso = "SELECT numero FROM pisos WHERE id = ?";
$stmt_piso = $conexion->prepare($query_piso);
$stmt_piso->bind_param("i", $piso);
$stmt_piso->execute();
$resultado_piso = $stmt_piso->get_result();
$fila_piso = $resultado_piso->fetch_assoc();
$piso_numero = $fila_piso['numero'];

// Traducir ID de habitación → numero_habitacion real
$query_hab = "SELECT numero_habitacion FROM habitaciones WHERE id = ?";
$stmt_hab = $conexion->prepare($query_hab);
$stmt_hab->bind_param("i", $habitacion);
$stmt_hab->execute();
$resultado_hab = $stmt_hab->get_result();
$fila_hab = $resultado_hab->fetch_assoc();
$habitacion_nombre = $fila_hab['numero_habitacion'];

// Insertar reporte con datos reales
$query = "INSERT INTO reportes (usuario_id, piso, habitacion, reporte, tipo_dano, estado) 
          VALUES (?, ?, ?, ?, ?, 'Ingresada')";
$stmt = $conexion->prepare($query);
$stmt->bind_param("iisss", $usuario_id, $piso_numero, $habitacion_nombre, $reporte, $tipo_dano);

if ($stmt->execute()) {
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
