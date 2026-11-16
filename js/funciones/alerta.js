/* SALUDO DE BIENVENIDA
   Se muestra una sola vez por sesión del navegador: si el usuario
   recarga la página o vuelve al inicio, no vuelve a aparecer. */

const CLAVE_SALUDO = "despensaSolcitoSaludoMostrado";

// Mostrar un saludo con alert()
function mostrarSaludo() {
    alert("¡Bienvenido a Despensa Solcito! Gracias por visitarnos.");
}

// Indica si el saludo ya se mostró en esta sesión
function saludoYaMostrado() {
    try {
        return sessionStorage.getItem(CLAVE_SALUDO) === "si";
    } catch (error) {
        return false;
    }
}

// Recuerda que el saludo ya se mostró
function recordarSaludo() {
    try {
        sessionStorage.setItem(CLAVE_SALUDO, "si");
    } catch (error) {
        // Si el navegador no permite guardar, el saludo puede repetirse
    }
}

document.addEventListener("DOMContentLoaded", function () {
    if (saludoYaMostrado()) return;

    mostrarSaludo();
    recordarSaludo();
});
