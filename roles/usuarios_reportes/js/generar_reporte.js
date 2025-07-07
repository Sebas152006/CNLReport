function generarTextoReporte() {
    var piso = document.getElementById("select_piso").value;
    var habitacion = document.getElementById("select_habitacion").value;
    var tipoDano = document.getElementById("select_dano").value;

    var mensaje = "Cordial saludo. Se reporta el timbre de la habitación " + piso + habitacion + " debido a la siguiente novedad: " + tipoDano + ". Quedo atento a su pronta respuesta. Cordialmente.";

    document.getElementById("inputReporte").value = mensaje;
}

document.getElementById("select_piso").addEventListener("change", generarTextoReporte);
document.getElementById("select_habitacion").addEventListener("change", generarTextoReporte);
document.getElementById("select_dano").addEventListener("change", generarTextoReporte);
            