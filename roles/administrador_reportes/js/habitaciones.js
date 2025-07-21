document.getElementById("select_piso").addEventListener("change", function () {
    var piso_id = this.value;

    fetch("../../php/cargar_habitaciones.php?piso_id=" + piso_id)
        .then(response => response.text())
        .then(data => {
            document.getElementById("select_habitacion").innerHTML = data;
        })
        .catch(error => console.log("Error al cargar habitaciones:", error));
});