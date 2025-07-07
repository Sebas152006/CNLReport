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
    $estado = $_POST['estado'];

    $sql = "UPDATE reportes SET estado = :estado WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':estado', $estado);
    $stmt->bindParam(':id', $reporte_id);
    $stmt->execute();

    header("Location: consultar_reportes.php");
    exit;
}
?>
