<?php
require '../../../php/conexion_be.php';

// CREA LA CONEXIÓN PDO AQUÍ
$pdo = new PDO("mysql:host=localhost;dbname=cnl_report", 'root', '');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['reporte_id'];
    $respuesta = $_POST['respuesta'];
    $estado = $_POST['estado'];
    $fecha_respuesta = date('Y-m-d H:i:s');

    // Función para comprimir imagen
    function comprimirImagen($archivoTmp, $calidad = 70) {
        $info = getimagesize($archivoTmp);
        $tipo = $info['mime'];

        switch ($tipo) {
            case 'image/jpeg':
                $imagen = imagecreatefromjpeg($archivoTmp);
                break;
            case 'image/png':
                $imagen = imagecreatefrompng($archivoTmp);
                imagepalettetotruecolor($imagen);
                break;
            case 'image/webp':
                $imagen = imagecreatefromwebp($archivoTmp);
                break;
            default:
                return file_get_contents($archivoTmp);
        }

        ob_start();
        imagejpeg($imagen, null, $calidad);
        $imagenComprimida = ob_get_clean();
        imagedestroy($imagen);

        return $imagenComprimida;
    }

    $imagenAntes = null;
    $imagenDespues = null;

    if (!empty($_FILES['imagen_antes']['tmp_name'])) {
        $imagenAntes = comprimirImagen($_FILES['imagen_antes']['tmp_name']);
    }

    if (!empty($_FILES['imagen_despues']['tmp_name'])) {
        $imagenDespues = comprimirImagen($_FILES['imagen_despues']['tmp_name']);
    }

    $sql = "UPDATE reportes 
            SET respuesta = ?, 
                estado = ?, 
                fecha_respuesta = ?, 
                imagen_antes = COALESCE(?, imagen_antes), 
                imagen_despues = COALESCE(?, imagen_despues) 
            WHERE id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$respuesta, $estado, $fecha_respuesta, $imagenAntes, $imagenDespues, $id]);

    header("Location: gestionar_reportes.php");
    exit;
}
?>
