/* MENUS DEL SITIO: perfil desplegable.
   El enlace activo del menú principal lo marca PHP en includes/nav.php */

// Menú desplegable de "Mi perfil"
function iniciarMenuPerfil() {
    const boton = document.getElementById("perfilBoton");
    const menu = document.getElementById("perfilMenu");

    if (!boton || !menu) return;

    function cerrar() {
        menu.hidden = true;
        boton.setAttribute("aria-expanded", "false");
    }

    // Abrir o cerrar al hacer clic en el botón
    boton.addEventListener("click", function () {
        const abierto = boton.getAttribute("aria-expanded") === "true";

        boton.setAttribute("aria-expanded", String(!abierto));
        menu.hidden = abierto;
    });

    // Cerrar al hacer clic fuera del menú
    document.addEventListener("click", function (evento) {
        if (!evento.target.closest(".dropdown-menu")) {
            cerrar();
        }
    });

    // Cerrar al presionar Escape
    document.addEventListener("keydown", function (evento) {
        if (evento.key === "Escape" && !menu.hidden) {
            cerrar();
            boton.focus();
        }
    });
}

document.addEventListener("DOMContentLoaded", function () {
    iniciarMenuPerfil();
});
