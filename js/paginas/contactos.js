/* PAGINA DE CONTACTOS */

// Clave donde la página de Configuración guarda los datos del perfil
const CLAVE_PERFIL_CONTACTOS = "despensaSolcitoConfiguracion";

// Completa nombre y correo con los datos guardados en Configuración
function completarDatosGuardados(formulario) {
    try {
        const guardada = localStorage.getItem(CLAVE_PERFIL_CONTACTOS);
        const datos = guardada ? JSON.parse(guardada) : {};

        const campoNombre = formulario.elements["nombre"];
        const campoCorreo = formulario.elements["correo"];

        const nombre = [datos.nombre, datos.apellido]
            .filter(Boolean)
            .join(" ");

        if (campoNombre && !campoNombre.value && nombre) {
            campoNombre.value = nombre;
        }

        if (campoCorreo && !campoCorreo.value && datos.correo) {
            campoCorreo.value = datos.correo;
        }
    } catch (error) {
        // Si no se puede leer, el formulario queda vacío
    }
}

document.addEventListener("DOMContentLoaded", function () {
    const formulario = document.getElementById("formContacto");
    const mensaje = document.getElementById("mensajeContacto");

    if (!formulario) return;

    completarDatosGuardados(formulario);

    // El envío lo hace el servidor (contactos.php). Aquí solo se limpian
    // los mensajes de error cuando el usuario vuelve a escribir.
    formulario.addEventListener("input", function () {
        if (mensaje) mensaje.textContent = "";
    });
});
