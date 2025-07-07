<?php
require 'conexion_be.php'; // Asegúrate de que la ruta es correcta

$piso_numero = intval($_GET['piso_id']); // Convertir a número

// Obtener el ID real del piso
$query_piso = "SELECT id FROM pisos WHERE numero = ?";
$stmt_piso = $conexion->prepare($query_piso);
$stmt_piso->bind_param("i", $piso_numero);
$stmt_piso->execute();
$resultado_piso = $stmt_piso->get_result();
$fila_piso = $resultado_piso->fetch_assoc();

if (!$fila_piso) {
    echo "<option value=''>Error: Piso no encontrado</option>";
    exit;
}

$piso_id = $fila_piso['id']; // ID correcto del piso

// Ahora consultar las habitaciones con el ID correcto del piso
$query_habitaciones = "SELECT numero_habitacion FROM habitaciones WHERE piso_id = ?";
$stmt_habitaciones = $conexion->prepare($query_habitaciones);
$stmt_habitaciones->bind_param("i", $piso_id);
$stmt_habitaciones->execute();
$resultado_habitaciones = $stmt_habitaciones->get_result();

if ($resultado_habitaciones->num_rows == 0) {
    echo "<option value=''>No hay habitaciones disponibles</option>";
} else {
    echo '<option value="">Selecciona una habitación</option>';
    while ($fila_habitacion = $resultado_habitaciones->fetch_assoc()) {
        echo '<option value="' . $fila_habitacion['numero_habitacion'] . '">Habitación ' . $fila_habitacion['numero_habitacion'] . '</option>';
    }
}
?>
