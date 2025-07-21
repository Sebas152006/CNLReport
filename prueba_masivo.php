<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['archivo_csv'])) {
    $archivoTmp = $_FILES['archivo_csv']['tmp_name'];

    $pdo = new PDO("mysql:host=localhost;dbname=cnl_report", 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $usuario_id = 1; // ID del administrador

    if (($archivo = fopen($archivoTmp, "r")) !== false) {
        fgetcsv($archivo); // omitir encabezado

        $importados = 0;
        while (($fila = fgetcsv($archivo, 1000, ",")) !== false) {
            list($piso, $habitacion, $tipo_dano, $estado, $reporte, $fecha_creacion) = $fila;

            $sql = "INSERT INTO reportes (usuario_id, piso, habitacion, tipo_dano, estado, reporte, fecha_creacion)
                    VALUES (?, ?, ?, ?, ?, ?, ?)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$piso, $habitacion, $tipo_dano, $estado, $reporte, $fecha_creacion]);
            $importados++;
        }

        fclose($archivo);
        echo "<p><strong>$importados reportes importados correctamente.</strong></p>";
    } else {
        echo "<p>Error al abrir el archivo.</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Carga Masiva de Reportes</title>
</head>
<body>
    <h2>Cargar Reportes desde CSV</h2>
    <form method="POST" enctype="multipart/form-data">
        <label for="archivo_csv">Selecciona archivo CSV:</label><br>
        <input type="file" name="archivo_csv" accept=".csv" required><br><br>
        <button type="submit">Subir y Cargar</button>
    </form>
</body>
</html>
