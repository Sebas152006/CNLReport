function habilitarEdicion(id) {
    const fila = document.getElementById(`fila-${id}`); // Selecciona la fila específica por ID
    const inputs = fila.querySelectorAll('input, textarea'); // Encuentra todos los campos de la fila
    inputs.forEach(input => input.disabled = false); // Habilita cada campo
    const botonGuardar = fila.querySelector('button[type="submit"]'); // Habilita el botón Guardar
    if (botonGuardar) {
        botonGuardar.disabled = false;
    }
}


