<?php
session_start();
require '../../../php/conexion_be.php';

// Validar sesión
if (!isset($_SESSION['id'])) {
    die("Error: Usuario no autenticado.");
}
$usuario_id = $_SESSION['id'];

// Conexión PDO
$pdo = new PDO("mysql:host=localhost;dbname=cnl_report", 'root', '');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['reporte_id'];
    $respuesta = $_POST['respuesta'];
    $estado = $_POST['estado'];
    $fecha_respuesta = date('Y-m-d H:i:s');

    // Imágenes sin compresión (se guardan tal cual)
    $imagenAntes = null;
    $imagenDespues = null;

    if (!empty($_FILES['imagen_antes']['tmp_name'])) {
        $imagenAntes = file_get_contents($_FILES['imagen_antes']['tmp_name']);
    }

    if (!empty($_FILES['imagen_despues']['tmp_name'])) {
        $imagenDespues = file_get_contents($_FILES['imagen_despues']['tmp_name']);
    }

    // Actualización SQL con usuario que responde
    $sql = "UPDATE reportes 
            SET respuesta = ?, 
                estado = ?, 
                fecha_respuesta = ?, 
                imagen_antes = COALESCE(?, imagen_antes), 
                imagen_despues = COALESCE(?, imagen_despues),
                respondido_por = ?
            WHERE id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        $respuesta,
        $estado,
        $fecha_respuesta,
        $imagenAntes,
        $imagenDespues,
        $usuario_id,
        $id
    ]);

    header("Location: ../gestionar_reportes.php");
    exit;
}
?>
