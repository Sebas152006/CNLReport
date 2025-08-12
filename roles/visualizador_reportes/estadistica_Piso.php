<?php
  require '../../php/verificar_sesion.php';
  verificarAcceso([3]); // Permitir acceso a rol 3
  require '../../php/conexion_be.php';

  $inicio = $_GET['fecha_inicio'] ?? '2000-01-01';
  $fin = $_GET['fecha_fin'] ?? date('Y-m-d');

  // Reportes por piso
  $sqlPiso = "SELECT piso, COUNT(*) AS total 
              FROM reportes 
              WHERE fecha BETWEEN '$inicio' AND '$fin'
              GROUP BY piso 
              ORDER BY piso ASC";
  $resPiso = $conexion->query($sqlPiso);
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Gráficas de Diagnóstico</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../../css/diagnostico.css">
  <link rel="stylesheet" href="../../css/estilos2.css">
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
  <?php include '../../menu_lateral/menu3.php'; ?>

  <div class="contenedor-estadisticas">
    <form method="GET" class="form-fechas">
        <label for="fecha_inicio">Fecha Inicio:</label>
        <input type="date" name="fecha_inicio" id="fecha_inicio" required>
  
        <label for="fecha_fin">Fecha Fin:</label>
        <input type="date" name="fecha_fin" id="fecha_fin" required>
  
        <button type="submit">Filtrar 📅</button>
    </form>

    <h2>Reportes por Piso</h2>
    <canvas id="graficoPisos"></canvas>
  </div>

  <script>
    // Pisos
    const etiquetasPiso = [<?php while ($row = $resPiso->fetch_assoc()) echo "'Piso ".$row['piso']."',"; ?>];
    const datosPiso = [<?php $resPiso->data_seek(0); while ($row = $resPiso->fetch_assoc()) echo $row['total'].','; ?>];

    new Chart(document.getElementById('graficoPisos').getContext('2d'), {
      type: 'bar',
      data: {
        labels: etiquetasPiso,
        datasets: [{
          label: 'Reportes por piso',
          data: datosPiso,
          backgroundColor: '#00cec9'
        }]
      },
      options: {
        responsive: true,
        scales: { y: { beginAtZero: true } }
      }
    });
  </script>
</body>
</html>
