<?php
require 'conexion_be.php'; // Importa la conexión

$numero_piso = $_POST['numero_piso'];

$query = "INSERT INTO pisos (numero) VALUES (?)";
$stmt = $conexion->prepare($query); // Usa `mysqli`, no `$pdo`
$stmt->bind_param("i", $numero_piso);
$stmt->execute();
$stmt->close();

echo "✅ Piso agregado correctamente.";
?>
