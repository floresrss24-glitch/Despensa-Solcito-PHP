<?php
$titulo_pagina = 'Ayuda y soporte';
$hojas_estilo = ['css/style.css', 'css/ayuda.css'];

require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/includes/nav.php';
?>
    <section class="ayuda-header">
        <h1>Ayuda y soporte</h1>
        <p>Encontrá respuestas rápidas o escribinos si necesitás más ayuda.</p>
    </section>

    <section class="ayuda-contenedor">

        <details class="ayuda-item" open>
            <summary>¿Cómo hago un pedido?</summary>
            <p>Entrá a <a href="compras.php">Compras</a>, elegí la categoría, la cantidad y el tipo de entrega, y confirmá el resumen. Si tenés una cuenta, el pedido queda asociado a tu correo.</p>
        </details>

        <details class="ayuda-item">
            <summary>¿Qué medios de pago aceptan?</summary>
            <p>Efectivo, tarjetas de débito y crédito. Si pagás por transferencia, podés adjuntar el comprobante al hacer el pedido (JPG, PNG o PDF de hasta 2 MB).</p>
        </details>

        <details class="ayuda-item">
            <summary>¿Cuál es el horario de atención?</summary>
            <p>De lunes a sábado de 08:00 a 22:00 hs.</p>
        </details>

        <details class="ayuda-item">
            <summary>¿Cómo guardo productos en favoritos?</summary>
            <p>Iniciá sesión, entrá a una categoría desde <a href="producto.php">Productos</a> y tocá «Agregar a favoritos». Tu lista está en <a href="favoritos.php">Productos favoritos</a>.</p>
        </details>

        <details class="ayuda-item">
            <summary>Olvidé mi contraseña</summary>
            <p>Por ahora no hay recuperación automática. Escribinos desde <a href="contactos.php">Contactos</a> indicando el correo de tu cuenta.</p>
        </details>

        <p class="ayuda-contacto">
            ¿No encontraste lo que buscabas?
            <a href="contactos.php">Escribinos</a> o mandá un correo a
            <a href="mailto:<?= e(APP_EMAIL) ?>"><?= e(APP_EMAIL) ?></a>.
            También podés revisar las <a href="preguntas_frecuentes.php">preguntas frecuentes</a>.
        </p>

    </section>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
