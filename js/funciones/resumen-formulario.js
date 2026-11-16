/* RESUMEN DE FORMULARIO
   Uso: <form data-resumen="idDelContenedor"> y un contenedor con ese id.
   Al enviar un formulario válido muestra los datos cargados en el contenedor
   y pide confirmación. Solo al confirmar se envía al servidor.
   Cargar este archivo DESPUÉS de validaciones.js. */

// Limpia el texto de una etiqueta: quita asteriscos y aclaraciones
function limpiarEtiqueta(texto) {
    return texto
        .replace(/\(opcional\)/i, "")
        .replace(/\*/g, "")
        .replace(/\s+/g, " ")
        .trim();
}

// Busca el nombre visible de un campo
function obtenerEtiqueta(campo) {
    // Los grupos de opciones usan un título propio (.form-label)
    if (campo.type === "radio") {
        const grupo = campo.closest(".form-group");
        const titulo = grupo && grupo.querySelector(".form-label");
        if (titulo) return limpiarEtiqueta(titulo.textContent);
    }

    if (campo.labels && campo.labels.length > 0) {
        return limpiarEtiqueta(campo.labels[0].textContent);
    }

    return campo.name || campo.id;
}

// Obtiene el valor del campo como texto legible
function obtenerValor(formulario, campo) {
    if (campo.type === "radio") {
        const elegido = formulario.querySelector(
            'input[type="radio"][name="' + campo.name + '"]:checked'
        );
        return elegido ? limpiarEtiqueta(elegido.parentElement.textContent) : "";
    }

    if (campo.type === "checkbox") return campo.checked ? "Sí" : "No";

    if (campo.type === "file") {
        return campo.files.length > 0 ? campo.files[0].name : "";
    }

    if (campo.tagName === "SELECT") {
        return campo.value ? campo.options[campo.selectedIndex].text : "";
    }

    return campo.value.trim();
}

// Arma la lista de datos del resumen
function construirResumen(formulario) {
    const lista = document.createElement("dl");
    const vistos = new Set();

    Array.from(formulario.elements).forEach(function (campo) {
        const ignorar = ["hidden", "submit", "reset", "button"];

        if (!campo.name || ignorar.includes(campo.type)) return;

        // Los botones de opción comparten nombre: se muestran una sola vez
        if (vistos.has(campo.name)) return;
        vistos.add(campo.name);

        const titulo = document.createElement("dt");
        titulo.textContent = obtenerEtiqueta(campo);

        const dato = document.createElement("dd");
        dato.textContent = obtenerValor(formulario, campo) || "No indicado";

        lista.append(titulo, dato);
    });

    return lista;
}

function iniciarResumen(formulario) {
    const contenedor = document.getElementById(formulario.dataset.resumen);
    if (!contenedor) return;

    // Cuando el usuario confirma, se envía el formulario sin volver a pasar por aquí
    let confirmado = false;

    formulario.addEventListener("submit", function (evento) {
        // Si la validación encontró errores, no se muestra nada
        if (evento.defaultPrevented) return;

        // Ya confirmó el resumen: el formulario viaja al servidor
        if (confirmado) return;

        evento.preventDefault();

        const titulo = document.createElement("h3");
        titulo.textContent = "Revisá tu pedido antes de enviarlo";

        const aviso = document.createElement("p");
        aviso.className = "resumen-aviso";
        aviso.textContent = "Si los datos son correctos, confirmá el pedido.";

        const botonConfirmar = document.createElement("button");
        botonConfirmar.type = "button";
        botonConfirmar.className = "btn-enviar";
        botonConfirmar.textContent = "Confirmar y enviar";

        const botonEditar = document.createElement("button");
        botonEditar.type = "button";
        botonEditar.className = "btn-reset";
        botonEditar.textContent = "Editar datos";

        const acciones = document.createElement("div");
        acciones.className = "form-buttons";
        acciones.append(botonConfirmar, botonEditar);

        botonConfirmar.addEventListener("click", function () {
            confirmado = true;
            formulario.requestSubmit();
        });

        botonEditar.addEventListener("click", function () {
            contenedor.hidden = true;
            contenedor.replaceChildren();
            formulario.querySelector("select, input:not([type=hidden])").focus();
        });

        contenedor.replaceChildren(titulo, construirResumen(formulario), aviso, acciones);
        contenedor.hidden = false;
        contenedor.scrollIntoView({ behavior: "smooth", block: "nearest" });
    });

    // Al borrar el formulario también se oculta el resumen
    formulario.addEventListener("reset", function () {
        confirmado = false;
        contenedor.hidden = true;
        contenedor.replaceChildren();
    });
}

document.addEventListener("DOMContentLoaded", function () {
    document.querySelectorAll("form[data-resumen]").forEach(iniciarResumen);
});
