<?php
$titulo_pagina = 'Sobre nosotros';
$hojas_estilo = ['css/style.css', 'css/sobre_nosotros.css'];

require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/includes/nav.php';
?>
    <!-- SOBRE NOSOTROS -->
    <section class="about-header">
        <h1>Sobre Nosotros</h1>
        <p>Conoce más sobre <?= e(APP_NAME) ?> y nuestra historia.</p>
    </section>

    <section class="about-container">
        <div class="about-image">
            <img src="img/fotos/local.jpeg" alt="Despensa Solcito">
        </div>

        <div class="about-content">

            <h2>¿Quiénes Somos?</h2>

            <p>
                En <strong><?= e(APP_NAME) ?></strong> trabajamos cada día para ofrecer
                productos de calidad, precios accesibles y una atención cercana para
                todas las familias de nuestra comunidad.
            </p>

            <p>
                Desde nuestros comienzos, nuestro objetivo ha sido brindar un lugar
                donde los vecinos puedan encontrar todo lo necesario para su hogar:
                bebidas, alimentos, artículos de limpieza, productos congelados y mucho más.
            </p>

            <h2>Nuestra Misión</h2>

            <p>
                Ofrecer productos de excelente calidad y atención personalizada,
                contribuyendo al bienestar de nuestros clientes mediante precios justos
                y un servicio confiable.
            </p>

            <h2>Nuestra Visión</h2>

            <p>
                Ser la despensa de referencia de la comunidad, reconocida por su
                compromiso, cercanía y variedad de productos.
            </p>
        </div>
    </section>

    <!-- VALORES -->
    <section class="valores">
        <h2>Nuestros Valores</h2>
        <div class="valores-grid">

            <div class="valor-card">
                <i class="fas fa-handshake"></i>
                <h3>Compromiso</h3>
                <p>Trabajamos con responsabilidad para nuestros clientes.</p>
            </div>

            <div class="valor-card">
                <i class="fas fa-heart"></i>
                <h3>Confianza</h3>
                <p>Construimos relaciones duraderas con la comunidad.</p>
            </div>

            <div class="valor-card">
                <i class="fas fa-store"></i>
                <h3>Calidad</h3>
                <p>Seleccionamos productos que cumplen altos estándares.</p>
            </div>

            <div class="valor-card">
                <i class="fas fa-users"></i>
                <h3>Atención</h3>
                <p>Brindamos un servicio amable y cercano.</p>
            </div>
        </div>
    </section>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
