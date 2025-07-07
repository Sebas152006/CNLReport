<?php
$host = 'localhost';
$dbname = 'cnl_report';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Error en la conexión: " . $e->getMessage());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $reporte_id = $_POST['reporte_id'];
    $respuesta = $_POST['respuesta'];

    $sql = "UPDATE reportes SET respuesta = :respuesta WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':respuesta', $respuesta);
    $stmt->bindParam(':id', $reporte_id);
    $stmt->execute();

    header("Location: consultar_reportes.php");
    exit;
}
?>
