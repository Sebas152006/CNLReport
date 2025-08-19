<?php
  require '../../php/verificar_sesion.php';
  verificarAcceso([3]); // Permitir acceso a rol 3
  require '../../php/conexion_be.php';

  $inicio = $_GET['fecha_inicio'] ?? '2000-01-01';
  $fin = $_GET['fecha_fin'] ?? date('Y-m-d');

  // Top 3 habitaciones
  $sqlTop = "SELECT habitacion, COUNT(*) AS total 
          FROM reportes 
          WHERE fecha BETWEEN '$inicio' AND '$fin'
          GROUP BY habitacion 
          ORDER BY total DESC 
          LIMIT 3";
  $topHab = $conexion->query($sqlTop);
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
  
        <button type="submit">FILTRAR</button>
    </form>

    <h2>Habitaciones Más Reportadas</h2>
    <canvas id="graficoTop3"></canvas>
  </div>

  <script>
    // Top 3
    const etiquetasTop = [<?php while ($row = $topHab->fetch_assoc()) echo "'".$row['habitacion']."',"; ?>];
    const datosTop = [<?php $topHab->data_seek(0); while ($row = $topHab->fetch_assoc()) echo $row['total'].','; ?>];

    new Chart(document.getElementById('graficoTop3').getContext('2d'), {
      type: 'bar',
      data: {
        labels: etiquetasTop,
        datasets: [{
          label: 'Top 3 habitaciones',
          data: datosTop,
          backgroundColor: '#fd79a8'
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
