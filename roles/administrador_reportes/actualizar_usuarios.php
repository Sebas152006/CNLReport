<?php
if (isset($_POST['btnGuardar'])) {
    $id = $_POST['btnGuardar'];
    $rol = $_POST['rol'];
    $primer_nombre = $_POST['primer_nombre'];
    $segundo_nombre = $_POST['segundo_nombre'];
    $primer_apellido = $_POST['primer_apellido'];
    $segundo_apellido = $_POST['segundo_apellido'];
    $correo = $_POST['correo'];
    $numero_documento = $_POST['numero_documento'];
    $contrasenia = $_POST['contrasenia']; // Lo que viene del formulario

    // Revisa si la contraseña se dejó vacía
    if (!empty($contrasenia)) {
        // Si el usuario ingresó algo nuevo, encripta la contraseña
        $contrasenia_encriptada = password_hash($contrasenia, PASSWORD_BCRYPT);
    } else {
        // Si el usuario no tocó la contraseña, toma la existente de la base de datos
        $query = "SELECT contrasenia FROM usuarios WHERE id = '$id'";
        $result = mysqli_query($conexion, $query);
        $row = mysqli_fetch_assoc($result);
        $contrasenia_encriptada = $row['contrasenia'];
    }

    // Actualiza los demás datos del usuario
    $sql = "UPDATE usuarios SET 
                rol = '$rol', 
                primer_nombre = '$primer_nombre', 
                segundo_nombre = '$segundo_nombre',
                primer_apellido = '$primer_apellido', 
                segundo_apellido = '$segundo_apellido', 
                correo = '$correo', 
                numero_documento = '$numero_documento', 
                contrasenia = '$contrasenia_encriptada' 
            WHERE id = '$id'";

    if (mysqli_query($conexion, $sql)) {
        echo "<script>alert('Usuario actualizado con éxito');</script>";
        header("Location: gestionar_usuarios.php");
        exit();
    } else {
        echo "<script>alert('Error al actualizar el usuario: " . mysqli_error($conexion) . "');</script>";
    }
}

?>