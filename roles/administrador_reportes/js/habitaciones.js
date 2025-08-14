function cargarHabitaciones() {
    const piso_id = document.getElementById("select_piso").value;
    const fase = document.getElementById("select_fase").value;

    if (piso_id && fase) {
        fetch(`../../php/cargar_habitaciones.php?piso_id=${piso_id}&fase=${fase}`)
            .then(response => response.text())
            .then(data => {
                document.getElementById("select_habitacion").innerHTML = data;
            })
            .catch(error => console.log("Error al cargar habitaciones:", error));
    }
}

document.getElementById("select_piso").addEventListener("change", cargarHabitaciones);
document.getElementById("select_fase").addEventListener("change", cargarHabitaciones);
