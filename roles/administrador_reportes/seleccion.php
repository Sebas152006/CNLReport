<?php
    require '../../php/verificar_sesion.php';
    verificarAcceso([1]); // Permitir acceso a rol 1 y 2
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../css/estilos.css">
    <link rel="stylesheet" href="../../css/seleccion2.css">
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
    <?php include '../../menu_lateral/menu2.php'; ?>

    <div class="cartas">
        <!-- Timbres -->
        <a href="reporte_Timbres.php" class="carta">
            <div class="fondo_carta"
            style="background-image: url('images/timbre.jpeg');"></div>
            <div class="contenido-carta">
                <p>Reporte</p>
                <h3>Timbres</h3>
            </div>
        </a>

        <!-- Mis Reportes -->
        <a href="consultar_reportes.php" class="carta">
            <div class="fondo_carta"
            style="background-image: url('images/Gestion_Reporte.png');"></div>
            <div class="contenido-carta">
                <p>Reportes</p>
                <h3>Mis Reportes</h3>
            </div>
        </a>

        <!-- Gestionar Reportes -->
        <a href="gestionar_reportes.php" class="carta">
            <div class="fondo_carta"
            style="background-image: url('images/Gestionar_Reportes.png');"></div>
            <div class="contenido-carta">
                <p>Reportes</p>
                <h3>Gestionar Reportes</h3>
            </div>
        </a>

        <!-- Gestionar Usuarios -->
        <a href="gestionar_usuarios.php" class="carta">
            <div class="fondo_carta"
            style="background-image: url('images/Gestionar_Usuarios.png');"></div>
            <div class="contenido-carta">
                <p>Usuarios</p>
                <h3>Gestionar Usuarios</h3>
            </div>
        </a>

        <!-- Gestionar Pisos -->
        <a href="gestionar_pisos.php" class="carta">
            <div class="fondo_carta"
            style="background-image: url('images/Gestionar_Pisos.png');"></div>
            <div class="contenido-carta">
                <p>Pisos</p>
                <h3>Gestionar Pisos</h3>
            </div>
        </a>

        <!-- Importar Reportes -->
        <a href="importar_reportes.php" class="carta">
            <div class="fondo_carta"
            style="background-image: url('images/Importar_Reportes.png');"></div>
            <div class="contenido-carta">
                <p>Reportes</p>
                <h3>Importar Reportes</h3>
            </div>
        </a>

        <!-- Importar Imagenes -->
        <a href="super_admin.php" class="carta">
            <div class="fondo_carta"
            style="background-image: url('images/Importar_Reportes.png');"></div>
            <div class="contenido-carta">
                <p>Reportes</p>
                <h3>Importar Imagenes</h3>
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