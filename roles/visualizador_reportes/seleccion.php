<?php
require '../../php/verificar_sesion.php';
verificarAcceso([3]); // Permitir acceso a rol 3
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../css/estilos.css">
    <link rel="stylesheet" href="../../css/seleccion.css">
    <title>Menú</title>
    <link rel="icon" href="../../images/CNLReport_pequena.png" type="image/png">
    <script>
        const titulos = ["CNLReport", "Menú"];
        let index = 0;

        setInterval(() => {
            document.title = titulos[index];
            index = (index + 1) % titulos.length;
        }, 3000);
    </script>
</head>
<body>
    <!-- Importa el menu lateral -->
    <?php include '../../menu_lateral/menu3.php'; ?>

    <div class="cartas">
        <!-- Estadisticas Generales -->
        <a href="estadisticas_Generales.php" class="carta">
            <div class="fondo_carta"
            style="background-image: url('images/Estadistica_General.png');"></div>
            <div class="contenido-carta">
                <p>Estadisticas</p>
                <h3>Generales</h3>
            </div>
        </a>

        <!-- Estadisticas Por Habitacion -->
        <a href="estadistica_Habitacion.php" class="carta">
            <div class="fondo_carta"
            style="background-image: url('images/Reportes_Habitacion.png');"></div>
            <div class="contenido-carta">
                <p>Estadisticas</p>
                <h3>Reportes Por Habitación</h3>
            </div>
        </a>

        <!-- Estadisticas Por Piso -->
        <a href="estadistica_Piso.php" class="carta">
            <div class="fondo_carta"
            style="background-image: url('images/Reportes_Piso.png');"></div>
            <div class="contenido-carta">
                <p>Estadisticas</p>
                <h3>Reportes Por Piso</h3>
            </div>
        </a>

        <!-- Habitaciones Con Mas Reportes -->
        <a href="estadistica_Top.php" class="carta">
            <div class="fondo_carta"
            style="background-image: url('images/Reportes_Top.png');"></div>
            <div class="contenido-carta">
                <p>Estadisticas</p>
                <h3>Habitaciones Más Reportadas</h3>
            </div>
        </a>

        <!-- Gestionar Cuenta -->
        <a href="contrasenia.php" class="carta">
            <div class="fondo_carta"
            style="background-image: url('images/MI_CUENTA.png');"></div>
            <div class="contenido-carta">
                <p>Usuario</p>
                <h3>Mi Cuenta</h3>
            </div>
        </a>
    </div>
    
</body>
</html>