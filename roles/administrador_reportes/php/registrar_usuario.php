<?php
include '../../../php/conexion_be.php';

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["correo"])) {
    $nombre = $_POST["nombre"] ?? '';
    $apellido = $_POST["apellido"] ?? '';
    $documento = $_POST["documento"] ?? '';
    $correo = $_POST["correo"] ?? '';
    $contrasenia = password_hash($_POST["contrasenia"], PASSWORD_DEFAULT);
    $rol = $_POST["rol"] ?? '';

    $insert = "INSERT INTO usuarios (primer_nombre, primer_apellido, numero_documento, correo, contrasenia, rol)
               VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conexion->prepare($insert);
    $stmt->bind_param("sssssi", $nombre, $apellido, $documento, $correo, $contrasenia, $rol);

    if ($stmt->execute()) {
        echo "<script>alert('Usuario registrado correctamente'); location.href='../gestionar_usuarios.php';</script>";
    } else {
        echo "<script>alert('Error al registrar usuario');</script>";
    }
}
?>