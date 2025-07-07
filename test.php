<form action="php/guardar_habitacion.php" method="POST">
    <label>Piso:</label>
    <select name="piso_id">
        <?php
        require 'php/conexion_be.php';
        $query_pisos = "SELECT * FROM pisos";
        $resultado_pisos = $conexion->query($query_pisos);
        while ($fila = $resultado_pisos->fetch_assoc()) {
            echo '<option value="' . $fila['id'] . '">Piso ' . $fila['numero'] . '</option>';
        }
        ?>
    </select>

    <label>Habitación:</label>
    <input name="numero_habitacion" placeholder="Número de habitación" required>
    
    <button type="submit">Agregar Habitación</button>
</form>
