<?php
include 'php/conexion_be.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST["nombre"];
    $apellido = $_POST["apellido"];
    $documento = $_POST["documento"];
    $correo = $_POST["correo"];
    $contrasenia = password_hash($_POST["contrasenia"], PASSWORD_DEFAULT);
    $rol = $_POST["rol"];

    $sql = "INSERT INTO usuarios (primer_nombre, primer_apellido, numero_documento, correo, contrasenia, rol) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("sssssi", $nombre, $apellido, $documento, $correo, $contrasenia, $rol);
    
    if ($stmt->execute()) {
        echo "<script>alert('Usuario registrado correctamente');</script>";
    } else {
        echo "<script>alert('Error al registrar usuario');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro de Usuarios</title>
</head>
<body>
    <h2>Agregar Usuario</h2>
    <form method="POST">
        <label>Nombre: <input type="text" name="nombre" required></label><br>
        <label>Apellido: <input type="text" name="apellido" required></label><br>
        <label>Documento: <input type="text" name="documento" required></label><br>
        <label>Correo: <input type="email" name="correo" required></label><br>
        <label>Contraseña: <input type="password" name="contrasenia" required></label><br>
        <label>Rol: 
            <select name="rol">
                <option value="1">Administrador</option>
                <option value="2">Usuario</option>
                <option value="3">Supervisor</option>
            </select>
        </label><br>
        <input type="submit" value="Registrar">
    </form>

    <a href="php/cerrar_Sesion.php" class="cerrar_sesion">Cerrar Sesión</a>
</body>
</html>
