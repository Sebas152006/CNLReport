<?php
require '../../php/conexion_be.php';

// Conexión PDO (si no está en conexion_be.php)
$pdo = new PDO("mysql:host=localhost;dbname=cnl_report", 'root', '');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Parámetros
$id = $_GET['id'] ?? null;
$tipo = $_GET['tipo'] === 'despues' ? 'imagen_despues' : 'imagen_antes';

if ($id && in_array($tipo, ['imagen_antes', 'imagen_despues'])) {
    $stmt = $pdo->prepare("SELECT $tipo FROM reportes WHERE id = ?");
    $stmt->execute([$id]);
    $imagen = $stmt->fetchColumn();

    if ($imagen) {
        header("Content-Type: image/jpeg"); // Asegúrate de que sea JPEG
        echo $imagen;
        exit;
    }
}

http_response_code(404);
echo "Imagen no disponible.";
