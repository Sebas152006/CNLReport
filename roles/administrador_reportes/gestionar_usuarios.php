<?php
require '../../php/verificar_sesion.php';
verificarAcceso([1]); // Permitir acceso a rol 1
include '../../php/conexion_be.php';
include 'actualizar_usuarios.php';

// 🔍 Filtro de búsqueda
$buscar = isset($_GET['buscar']) ? $_GET['buscar'] : '';

// 🔢 Paginación
$usuariosPorPagina = 7;
$paginaActual = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
$inicio = ($paginaActual - 1) * $usuariosPorPagina;

// 📊 Total de usuarios
$countSql = "SELECT COUNT(*) as total FROM usuarios";
if (!empty($buscar)) {
    $countSql .= " WHERE numero_documento LIKE '%$buscar%'";
}
$countResult = mysqli_query($conexion, $countSql);
$totalUsuarios = mysqli_fetch_assoc($countResult)['total'];
$totalPaginas = ceil($totalUsuarios / $usuariosPorPagina);

// 📁 Consulta principal con LIMIT
$sql = "SELECT * FROM usuarios";
if (!empty($buscar)) {
    $sql .= " WHERE numero_documento LIKE '%$buscar%'";
}
$sql .= " LIMIT $inicio, $usuariosPorPagina";
$result = mysqli_query($conexion, $sql);
?>

<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="../../css/usuarios_admin.css">
        <link rel="stylesheet" href="../../css/estilos.css">
        <title>Gestionar Usuarios</title>
        <link rel="icon" href="../../images/CNLReport_pequena.png" type="image/png">
        <script>
            const titulos = ["CNLReport", "Gestionar Usuarios"];
            let index = 0;

            setInterval(() => {
                document.title = titulos[index];
                index = (index + 1) % titulos.length;
            }, 3000);
        </script>
        <script src="script4.js"></script>
    </head>
<body>
<?php include '../../menu_lateral/menu2.php'; ?>

<div class="contenedor-usuarios">
  <div class="encabezado-usuarios">
    <button id="abrir-modal" class="agregar-usuario">➕ Agregar Usuario</button>
  </div>

  <table>
    <thead>
      <tr>
        <th>Rol</th>
        <th>Id</th>
        <th>Primer Nombre</th>
        <th>Segundo Nombre</th>
        <th>Primer Apellido</th>
        <th>Segundo Apellido</th>
        <th>Documento</th>
        <th>Contraseña</th>
        <th>Editar</th>
        <th>Guardar</th>
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
          <td><input type="text" name="numero_documento" value="<?php echo $mostrar['numero_documento']; ?>" disabled></td>
          <td><input type="password" name="contrasenia" placeholder="Dejar vacío si no se cambia" disabled></td>
          <td><button type="button" onclick="habilitarEdicion(<?php echo $mostrar['id']; ?>)"><img src="images/1.png" alt="Editar"></button></td>
          <td>
            <button id="guardar-<?php echo $mostrar['id']; ?>" type="submit" name="btnGuardar" value="<?php echo $mostrar['id']; ?>" disabled>
              <img src="images/3.png" alt="Guardar">
            </button>
          </td>

        </form>
      </tr>
      <?php } ?>
    </tbody>
  </table>

  <!-- 🔽 Paginación -->
  <div class="paginacion">
    <?php
    $maxEnlaces = 10;
    $bloque = ceil($paginaActual / $maxEnlaces);
    $inicioBloque = ($bloque - 1) * $maxEnlaces + 1;
    $finBloque = min($inicioBloque + $maxEnlaces - 1, $totalPaginas);

    if ($inicioBloque > 1) {
        echo '<a href="?pagina=' . ($inicioBloque - 1) . ($buscar ? '&buscar=' . urlencode($buscar) : '') . '">&laquo;</a>';
    }

    for ($i = $inicioBloque; $i <= $finBloque; $i++) {
        $clase = ($i == $paginaActual) ? 'pagina-actual' : '';
        echo '<a href="?pagina=' . $i . ($buscar ? '&buscar=' . urlencode($buscar) : '') . '" class="' . $clase . '">' . $i . '</a>';
    }

    if ($finBloque < $totalPaginas) {
        echo '<a href="?pagina=' . ($finBloque + 1) . ($buscar ? '&buscar=' . urlencode($buscar) : '') . '">&raquo;</a>';
    }
    ?>
  </div>

<div id="modal-usuario" class="modal">
  <div class="modal-contenido">
    <span id="cerrar-modal" class="cerrar">&times;</span>
    <h2>Agregar Usuario</h2>
    <form method="POST" action="php/registrar_usuario.php">
      <input type="text" name="nombre" placeholder="Nombre" required>
      <input type="text" name="apellido" placeholder="Apellido" required>
      <input type="text" name="documento" placeholder="Documento" required>
      <input type="password" name="contrasenia" placeholder="Contraseña" required>
      <select name="rol" required>
        <option value="">Selecciona un rol</option>
        <option value="1">Administrador</option>
        <option value="2">Usuario</option>
        <option value="3">Visualizador</option>
      </select>
      <button type="submit">Registrar</button>
    </form>
  </div>
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
<script>
function habilitarEdicion(id) {
  const fila = document.getElementById(`fila-${id}`);
  const inputs = fila.querySelectorAll('input');
  const guardarBtn = fila.querySelector('button[name="btnGuardar"]');

  inputs.forEach(input => input.disabled = false);
  guardarBtn.disabled = false;

  // Cambiar color de fondo
  fila.style.backgroundColor = '#ffe797ff'; // Amarillo suave

  // Mostrar confirmación
  if (!fila.querySelector('.confirmacion-edicion')) {
    const confirmacion = document.createElement('td');
    confirmacion.colSpan = 10;
    confirmacion.className = 'confirmacion-edicion';
    confirmacion.innerHTML = `
      <div style="padding: 10px; background-color: #ffeeba; border: 1px solid #ffc107; border-radius: 6px;">
        ¿Quieres editar este usuario? 
        <button onclick="confirmarEdicion(${id})">Aceptar</button>
        <button onclick="cancelarEdicion(${id})">Cancelar</button>
      </div>
    `;
    fila.after(confirmacion);
  }
}

function confirmarEdicion(id) {
  const fila = document.getElementById(`fila-${id}`);
  const confirmacion = fila.nextElementSibling;

  if (confirmacion && confirmacion.classList.contains('confirmacion-edicion')) {
    confirmacion.remove();
  }

  fila.style.backgroundColor = '#27105ec2'; // Verde suave para indicar edición activa
}


function cancelarEdicion(id) {
  const fila = document.getElementById(`fila-${id}`);
  const inputs = fila.querySelectorAll('input');
  const guardarBtn = fila.querySelector('button[name="btnGuardar"]');
  const confirmacion = fila.nextElementSibling;

  inputs.forEach(input => input.disabled = true);
  guardarBtn.disabled = true;
  fila.style.backgroundColor = ''; // Restaurar color
  if (confirmacion && confirmacion.classList.contains('confirmacion-edicion')) {
    confirmacion.remove();
  }
}
</script>

</html>
