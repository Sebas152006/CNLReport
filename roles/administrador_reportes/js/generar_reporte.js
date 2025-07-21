function generarTextoReporte() {
    const piso = document.getElementById("select_piso").value;
    const habitacion = document.getElementById("select_habitacion").value;
    const tipoDanoSelect = document.getElementById("select_dano");
    const tipoDano = tipoDanoSelect.value;
    const otroDano = document.getElementById("otro_dano")?.value.trim();

    let tipoFinal = tipoDano;
    if (tipoDano === "Otro" && otroDano) {
        tipoFinal = "Otro - " + otroDano;
    }

    const mensaje = "Cordial saludo. Se reporta el timbre de la habitación " + piso + habitacion + 
                    " debido a la siguiente novedad: " + tipoFinal + 
                    ". Quedo atento a su pronta respuesta. Cordialmente.";

    document.getElementById("inputReporte").value = mensaje;
}

document.getElementById("select_piso").addEventListener("change", generarTextoReporte);
document.getElementById("select_habitacion").addEventListener("change", generarTextoReporte);
document.getElementById("select_dano").addEventListener("change", function () {
    const detalleOtro = document.getElementById("detalle_otro");
    if (this.value === "Otro") {
        detalleOtro.style.display = "block";
    } else {
        detalleOtro.style.display = "none";
    }
    generarTextoReporte(); // actualiza el mensaje
});
document.getElementById("otro_dano").addEventListener("input", generarTextoReporte);
