<?php
session_start();

if (isset($_SESSION['id']) && isset($_SESSION['rol'])) {
    $redirecciones = [
        1 => "roles/administrador_reportes/seleccion.php",
        2 => "roles/usuarios_reportes/seleccion.php",
        3 => "roles/visualizador_reportes/seleccion.php",
    ];

    header("Location: " . ($redirecciones[$_SESSION['rol']] ?? "error.php"));
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/index.css">
    <title>CNLReport</title>
    <link rel="icon" href="images/CNLReport_pequena.png" type="image/png">
</head>
<body>
    <div class="recuadro1">
        <section class="recuadro">
            <h2>Inicio de Sesión</h2>
            <div class="ingreso_usuario">
                <!--Formulario de inicio de sesion-->
                <form action="php/login_usuario_be.php" class="formulario_login" method="POST">
                    <p>Correo Electrónico</p>
                    <input type="text" name="numero_documento" required>
                    <p>Contraseña</p>
                    <input type="password" name="contrasenia" required>
                    <button class="inicio_sesion" type="submit">INICIAR SESIÓN</button>
                </form>
            </div>
        </section>
    </div>
</body>
</html>