<?php
$titulo_pagina = 'Preguntas frecuentes';
$hojas_estilo = ['css/style.css', 'css/preguntas_frecuentes.css'];

require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/includes/nav.php';
?>
    <section class="faq-header">
        <h1>Preguntas Frecuentes</h1>
        <p>Resolvemos las dudas más comunes de nuestros clientes.</p>
    </section>

    <section class="faq-container">

        <div class="faq-item">
            <h2>¿Cuál es el horario de atención?</h2>
            <p>Atendemos de lunes a sábado de 08:00 a 22:00 hs.</p>
        </div>

        <div class="faq-item">
            <h2>¿Aceptan tarjetas?</h2>
            <p>Sí, aceptamos efectivo, tarjetas de débito y crédito.</p>
        </div>

        <div class="faq-item">
            <h2>¿Realizan entregas a domicilio?</h2>
            <p>Sí, contamos con servicio de entrega dentro de la ciudad.</p>
        </div>

        <div class="faq-item">
            <h2>¿Cómo puedo conocer las promociones?</h2>
            <p>Puedes visitar nuestra sección Promociones o seguirnos en redes sociales.</p>
        </div>

        <div class="faq-item">
            <h2>¿Puedo reservar productos?</h2>
            <p>Sí, comunícate con nosotros por teléfono o WhatsApp.</p>
        </div>

    </section>

    <hr>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
