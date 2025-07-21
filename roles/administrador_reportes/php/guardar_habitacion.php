<?php
require '../../../php/conexion_be.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $piso_id = $_POST['piso_id'] ?? '';
  $numero = $_POST['numero_habitacion'] ?? '';

  if (!empty($piso_id) && !empty($numero)) {
    $piso_id = intval($piso_id); // aseguras entero
    $numero = trim($numero);     // limpias espacios

    $query = "INSERT INTO habitaciones (piso_id, numero_habitacion) VALUES (?, ?)";

    $stmt = $conexion->prepare($query);

    if ($stmt) {
      $stmt->bind_param("is", $piso_id, $numero);

      if ($stmt->execute()) {
        echo "<script>alert('Habitación registrada correctamente'); window.location.href='../gestionar_pisos.php';</script>";
      } else {
        echo "<script>alert('Error al registrar habitación: " . $stmt->error . "'); window.history.back();</script>";
      }

      $stmt->close();
    } else {
      echo "<script>alert('Error en la preparación del statement'); window.history.back();</script>";
    }
  } else {
    echo "<script>alert('Por favor completa todos los campos'); window.history.back();</script>";
  }
}
?>
