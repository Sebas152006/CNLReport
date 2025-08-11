<?php
session_start();
require '../../php/conexion_be.php';

// Obtener los pisos existentes
$query_pisos = "SELECT * FROM pisos ORDER BY numero ASC";
$resultado_pisos = $conexion->query($query_pisos);
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Gestión De Pisos</title>
  <link rel="stylesheet" href="../../css/gestionar_pisos.css">
  <link rel="stylesheet" href="../../css/estilos.css">
  <link rel="icon" href="../../images/CNLReport_pequena.png" type="image/png">
  <script>
      const titulos = ["CNLReport", "Gestión De Pisos"];
      let index = 0;

      setInterval(() => {
          document.title = titulos[index];
          index = (index + 1) % titulos.length;
      }, 3000);
  </script>
</head>
<body>
  <?php include '../../menu_lateral/menu2.php'; ?>

  <div class="contenedor-usuarios">
    <h2 style="color: #343062;">Agregar Piso</h2>
    <form method="POST" action="php/guardar_piso.php" class="datos-usuario">
      <label for="numero_piso">Número de piso:</label>
      <input type="number" name="numero_piso" id="numero_piso" required>
      <button type="submit">Registrar Piso</button>
    </form>

    <h2 style="color: #343062;">Agregar Habitación</h2>
    <form method="POST" action="php/guardar_habitacion.php" class="datos-usuario">
      <label for="piso_id">Selecciona un piso:</label>
      <select name="piso_id" id="piso_id" required>
        <option value="">-- Seleccionar Piso --</option>
        <?php while ($fila = $resultado_pisos->fetch_assoc()) {
          echo '<option value="' . $fila['id'] . '">Piso ' . htmlspecialchars($fila['numero']) . '</option>';
        } ?>
      </select>

      <label for="numero_habitacion">Número de habitación:</label>
      <input type="text" name="numero_habitacion" id="numero_habitacion" required>
      <button type="submit">Registrar Habitación</button>
    </form>
  </div>
</body>
</html>
