<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action="php/guardar_piso.php" method="POST">
    <input type="number" name="numero_piso" placeholder="Número de piso" required>
    <button type="submit">Agregar Piso</button>
    </form>

<p>test</p>


<form action="php/guardar_habitacion.php" method="POST">
    <label>Piso:</label>
    <select name="piso_id">
        <?php
            $query_pisos = "SELECT * FROM pisos";
            $resultado_pisos = $pdo->query($query_pisos);
            while ($fila = $resultado_pisos->fetch(PDO::FETCH_ASSOC)) {
                echo '<option value="' . $fila['id'] . '">Piso ' . $fila['numero'] . '</option>';
            }
            ?>
    </select>

    <label>Habitación:</label>
    <input type="number" name="numero_habitacion" placeholder="Número de habitación" required>
    
    <button type="submit">Agregar Habitación</button>
</form>

</body>
</html>