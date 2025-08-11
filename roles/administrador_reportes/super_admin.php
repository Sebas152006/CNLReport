<?php
session_start();
require '../../php/conexion_be.php';

if (!isset($_SESSION['id']) || $_SESSION['rol'] != '1') {
    die("Acceso denegado.");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['reporte_id'];

    $campos = [];
    $params = [];

    if (!empty($_FILES['imagen_antes']['tmp_name'])) {
        $imagenAntes = file_get_contents($_FILES['imagen_antes']['tmp_name']);
        $campos[] = "imagen_antes = ?";
        $params[] = $imagenAntes;
    }

    if (!empty($_FILES['imagen_despues']['tmp_name'])) {
        $imagenDespues = file_get_contents($_FILES['imagen_despues']['tmp_name']);
        $campos[] = "imagen_despues = ?";
        $params[] = $imagenDespues;
    }

    if (!empty($campos)) {
        $params[] = $id;
        $sql = "UPDATE reportes SET " . implode(', ', $campos) . " WHERE id = ?";
        $stmt = $conexion->prepare($sql);
        $stmt->bind_param(str_repeat('s', count($params) - 1) . 'i', ...$params);
        $stmt->execute();
        $mensaje = "✅ Imágenes actualizadas correctamente.";
    } else {
        $mensaje = "⚠️ No se seleccionó ninguna imagen.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Actualizar Imágenes de Reporte</title>
    <link rel="stylesheet" href="../../css/estilos.css">
    <link rel="icon" href="../../images/CNLReport_pequena.png" type="image/png">
</head>
<body>
    <?php include '../../menu_lateral/menu2.php'; ?>
    <h1>Actualizar Imágenes (Antes / Después)</h1>

    <?php if (isset($mensaje)): ?>
        <p style="color: green; font-weight: bold;"><?= $mensaje ?></p>
    <?php endif; ?>

    <form method="POST" enctype="multipart/form-data">
        <label>ID del reporte:</label><br>
        <input type="number" name="reporte_id" required><br><br>

        <label>Imagen Antes:</label><br>
        <input type="file" name="imagen_antes" accept="image/*"><br><br>

        <label>Imagen Después:</label><br>
        <input type="file" name="imagen_despues" accept="image/*"><br><br>

        <button type="submit">Actualizar Imágenes</button>
    </form>
</body>
</html>
