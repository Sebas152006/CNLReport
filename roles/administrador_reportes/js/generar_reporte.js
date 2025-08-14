function generarTextoReporte() {
    const pisoSelect = document.getElementById("select_piso");
    const faseSelect = document.getElementById("select_fase");
    const habitacionSelect = document.getElementById("select_habitacion");
    const tipoDanoSelect = document.getElementById("select_dano");
    const otroDano = document.getElementById("otro_dano")?.value.trim();

    const pisoTexto = pisoSelect.options[pisoSelect.selectedIndex]?.text || "";
    const faseTexto = faseSelect.options[faseSelect.selectedIndex]?.text || "";
    const habitacionTexto = habitacionSelect.options[habitacionSelect.selectedIndex]?.text || "";
    const tipoDano = tipoDanoSelect.value;

    let tipoFinal = tipoDano;
    if (tipoDano === "Otro" && otroDano) {
        tipoFinal = "Otro - " + otroDano;
    }

    const mensaje = `Cordial saludo. Se reporta timbre del piso ${pisoTexto}, habitación ${habitacionTexto}, ${faseTexto}, debido a la siguiente novedad: ${tipoFinal}. Quedo atento a su pronta respuesta. Cordialmente.`;

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
