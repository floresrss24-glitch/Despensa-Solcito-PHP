// Validar los formularios de la página
// Uso: agregar el atributo data-validar al <form>.
// Los campos con "required" no pueden quedar vacíos y los de tipo email
// deben tener un formato correcto. Los errores se muestran debajo del campo.

const EXPRESION_CORREO = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

// Devuelve el elemento después del cual se muestra el mensaje de error
function obtenerAnclaje(campo) {
    if (campo.type === "radio") {
        return campo.closest(".radio-group") || campo;
    }

    if (campo.type === "checkbox") {
        return campo.closest(".checkbox-group") || campo;
    }

    return campo;
}

// Busca el mensaje de error de un campo (o lo crea si no existe)
function obtenerMensaje(campo, crear) {
    const anclaje = obtenerAnclaje(campo);
    let mensaje = anclaje.nextElementSibling;

    if (mensaje && mensaje.classList.contains("mensaje-error")) {
        return mensaje;
    }

    if (!crear) return null;

    mensaje = document.createElement("small");
    mensaje.classList.add("mensaje-error");
    mensaje.setAttribute("role", "alert");
    anclaje.insertAdjacentElement("afterend", mensaje);

    return mensaje;
}

// Devuelve el texto del error de un campo, o "" si está correcto
function obtenerError(campo, formulario) {
    if (campo.type === "checkbox") {
        return campo.checked ? "" : "Debés aceptar para continuar.";
    }

    if (campo.type === "radio") {
        const elegido = formulario.querySelector(
            'input[type="radio"][name="' + campo.name + '"]:checked'
        );
        return elegido ? "" : "Elegí una opción.";
    }

    if (campo.value.trim() === "") {
        return campo.tagName === "SELECT"
            ? "Elegí una opción."
            : "Este campo es obligatorio.";
    }

    if (campo.type === "email" && !EXPRESION_CORREO.test(campo.value.trim())) {
        return "Ingresá un correo electrónico válido.";
    }

    return "";
}

document.addEventListener("DOMContentLoaded", function () {

    // Buscar los formularios que necesitan validación
    const formularios = document.querySelectorAll("[data-validar]");

    formularios.forEach(function (formulario) {

        // Se desactiva el globito del navegador para mostrar mensajes propios
        formulario.noValidate = true;

        const campos = formulario.querySelectorAll("[required]");

        formulario.addEventListener("submit", function (evento) {
            let formularioValido = true;
            let primerError = null;

            campos.forEach(function (campo) {
                const error = obtenerError(campo, formulario);
                const mensaje = obtenerMensaje(campo, error !== "");

                if (mensaje) mensaje.textContent = error;

                campo.setAttribute("aria-invalid", String(error !== ""));

                if (error !== "") {
                    formularioValido = false;
                    if (!primerError) primerError = campo;
                }
            });

            // Evitar el envío si existen errores y llevar el foco al primero
            if (!formularioValido) {
                evento.preventDefault();
                primerError.focus();
            }
        });

        // Limpiar el mensaje cuando el usuario modifica un campo
        campos.forEach(function (campo) {
            function limpiar() {
                const mensaje = obtenerMensaje(campo, false);
                if (mensaje) mensaje.textContent = "";
                campo.removeAttribute("aria-invalid");
            }

            campo.addEventListener("input", limpiar);
            campo.addEventListener("change", limpiar);
        });
    });
});
