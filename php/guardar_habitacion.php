<?php
require 'conexion_be.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $piso_id = $_POST['piso_id'];
    $numero_habitacion = $_POST['numero_habitacion'];

    $query = "INSERT INTO habitaciones (piso_id, numero_habitacion) VALUES (?, ?)";
    $stmt = $conexion->prepare($query);
    $stmt->bind_param("is", $piso_id, $numero_habitacion);
    $stmt->execute();
    $stmt->close();

    echo "✅ Habitación agregada correctamente.";
}
?>
