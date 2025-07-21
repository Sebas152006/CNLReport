<?php
session_start();

include '../../php/conexion_be.php';
include 'actualizar_usuarios.php';

// Filtro de búsqueda
$buscar = isset($_GET['buscar']) ? $_GET['buscar'] : '';
$sql = "SELECT * FROM usuarios";
if (!empty($buscar)) {
    $sql .= " WHERE correo_electronico LIKE '%$buscar%' OR documento LIKE '%$buscar%'";
}

$result = mysqli_query($conexion, $sql);
?>

<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="../../css/usuarios_admin.css">
        <link rel="stylesheet" href="../../css/estilos.css">
        <title>GreenShop</title>
        <script src="script4.js"></script>
    </head>
    <body>
        <!-- Importa el menu lateral -->
        <?php include '../../menu_lateral/menu2.php'; ?>
<button id="abrir-modal" class="agregar-usuario">➕ Agregar Usuario</button>

        <table>
            <thead>
                <tr>
                    <th>Rol</th>
                    <th>Id</th>
                    <th>Primer Nombre</th>
                    <th>Segundo Nombre</th>
                    <th>Primer Apellido</th>
                    <th>Segundo Apellido</th>
                    <th>Correo Electrónico</th>
                    <th>Documento</th>
                    <th>Contraseña</th>
                    <th>Editar</th>
                    <th>Guardar</th>
                    <th>Eliminar</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($mostrar = mysqli_fetch_array($result)) { ?>
                <tr id="fila-<?php echo $mostrar['id']; ?>">
                    <form method="POST" action="">
                        <td><input type="text" name="rol" value="<?php echo $mostrar['rol']; ?>" disabled></td>
                        <td><input type="text" name="id" value="<?php echo $mostrar['id']; ?>" readonly disabled></td>
                        <td><input type="text" name="primer_nombre" value="<?php echo $mostrar['primer_nombre']; ?>" disabled></td>
                        <td><input type="text" name="segundo_nombre" value="<?php echo $mostrar['segundo_nombre']; ?>" disabled></td>
                        <td><input type="text" name="primer_apellido" value="<?php echo $mostrar['primer_apellido']; ?>" disabled></td>
                        <td><input type="text" name="segundo_apellido" value="<?php echo $mostrar['segundo_apellido']; ?>" disabled></td>
                        <td><input type="email" name="correo" value="<?php echo $mostrar['correo']; ?>" disabled></td>
                        <td><input type="text" name="numero_documento" value="<?php echo $mostrar['numero_documento']; ?>" disabled></td>
                        <td><input type="password" name="contrasenia" placeholder="Dejar vacío si no se cambia" disabled></td>
                        <td>
                            <button type="button" onclick="habilitarEdicion(<?php echo $mostrar['id']; ?>)"><img src="images/1.png" alt="Editar"></button>
                        </td>
                        <td>
                            <button type="submit" name="btnGuardar" value="<?php echo $mostrar['id']; ?>" disabled><img src="images/3.png" alt="Guardar"></button>
                        </td>
                    </form>
                    <td>
                        <form action="eliminar.php" method="POST" class="eliminar2">
                            <input type="hidden" name="txtId" value="<?php echo $mostrar['id']; ?>">
                            <button type="submit" onclick="return confirm('¿Estás seguro de que deseas eliminar este usuario?');">
                                <img class="eliminar" src="images/2.png" alt="Eliminar">
                            </button>
                        </form>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>

        <div id="modal-usuario" class="modal">
  <div class="modal-contenido">
    <span id="cerrar-modal" class="cerrar">&times;</span>
    <h2>Agregar Usuario</h2>
    <form method="POST" action="ruta_del_archivo_que_agrega.php">
      <input type="text" name="nombre" placeholder="Nombre" required>
      <input type="text" name="apellido" placeholder="Apellido" required>
      <input type="text" name="documento" placeholder="Documento" required>
      <input type="email" name="correo" placeholder="Correo electrónico" required>
      <input type="password" name="contrasenia" placeholder="Contraseña" required>
      <select name="rol" required>
        <option value="">Selecciona un rol</option>
        <option value="1">Administrador</option>
        <option value="2">Usuario</option>
        <option value="3">Supervisor</option>
      </select>
      <button type="submit">Registrar</button>
    </form>
  </div>
</div>

<!-- Script para manejar el modal -->
<script>
document.getElementById("abrir-modal").onclick = function () {
  document.getElementById("modal-usuario").style.display = "block";
};

document.getElementById("cerrar-modal").onclick = function () {
  document.getElementById("modal-usuario").style.display = "none";
};

window.onclick = function (event) {
  if (event.target == document.getElementById("modal-usuario")) {
    document.getElementById("modal-usuario").style.display = "none";
  }
};
</script>

    </body>

    
</html>
