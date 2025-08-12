<?php
require '../../php/verificar_sesion.php';
verificarAcceso([1]); // Permitir acceso a rol 1
require '../../php/conexion_be.php';
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../css/importar_reportes.css">
    <link rel="stylesheet" href="../../css/estilos2.css">
    <title>Importar Reportes</title>
    <link rel="icon" href="../../images/CNLReport_pequena.png" type="image/png">
    <script>
        const titulos = ["CNLReport", "Importar Reportes"];
        let index = 0;

        setInterval(() => {
            document.title = titulos[index];
            index = (index + 1) % titulos.length;
        }, 3000);
    </script>
</head>
<body>
  <!-- Importa el menu lateral -->
  <?php include '../../menu_lateral/menu2.php'; ?>

  <div class="contenedor-importacion">
    <h2>📥 Importar Reportes Masivos (CSV)</h2>
    <form method="POST" enctype="multipart/form-data">
      <input type="file" name="archivo_csv" accept=".csv" required>
      <button type="submit" name="importar">Importar</button>
    </form>
  </div>

<?php
if (isset($_POST['importar']) && $_FILES['archivo_csv']['error'] === UPLOAD_ERR_OK) {
  $archivo = $_FILES['archivo_csv']['tmp_name'];
  $gestor = fopen($archivo, 'r');

  $encabezado = fgetcsv($gestor); // Saltar encabezado

  $insertados = 0;
  while (($fila = fgetcsv($gestor, 1000, ",")) !== false) {
    [$usuario_id, $piso, $habitacion, $reporte, $tipo_dano, $fecha, $estado, $respuesta, $fecha_creacion, $fecha_respuesta, $respondido_por] = array_map('trim', $fila);

    // Validaciones básicas (puedes extender)
    if (empty($piso) || empty($habitacion) || empty($reporte)) continue;

    $stmt = $conexion->prepare("INSERT INTO reportes (
    usuario_id, piso, habitacion, reporte, tipo_dano, fecha, estado, respuesta, fecha_creacion, fecha_respuesta, imagen_antes, imagen_despues, respondido_por
  ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NULL, NULL, ?)");

$stmt->bind_param("iissssssssi", 
  $usuario_id, 
  $piso, 
  $habitacion, 
  $reporte, 
  $tipo_dano, 
  $fecha, 
  $estado, 
  $respuesta, 
  $fecha_creacion, 
  $fecha_respuesta, 
  $respondido_por
);


    if ($stmt->execute()) {
      $insertados++;
    }
  }

  fclose($gestor);
  echo "<div style='text-align:center; margin-top:20px; font-weight:bold;'>✅ Se importaron correctamente $insertados reportes.</div>";
}
?>

</body>
</html>