<?php
$titulo_pagina = 'Promociones';
$hojas_estilo = ['css/style.css', 'css/promociones.css'];

require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/includes/nav.php';
?>
    <!-- PROMOCIONES -->
    <section class="promo-container">

        <div class="promo-header">
            <h2>PROMOCIONES</h2>

            <img src="img/fotos/promocion.jpg" alt="Imagen representativa de las promociones de Despensa Solcito">
        </div>

        <!-- PROMO 1 -->
        <div class="promo-card">
            <div class="promo-badge">
                10%
            </div>

            <div class="promo-info">
                <h3>EN GASEOSAS</h3>
                <p>Por comprar desde $10.000</p>
            </div>

            <a href="#" class="promo-btn">
                VER MÁS
            </a>
        </div>

        <!-- PROMO 2 -->
        <div class="promo-card">

            <div class="promo-badge">
                2×1
            </div>

            <div class="promo-info">
                <h3>EN GOLOSINAS</h3>
                <p>Lleva 2 y paga 1</p>
            </div>

            <a href="producto.php" class="promo-btn">
                Ver más sobre la promoción de gaseosas
            </a>
        </div>
    </section>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
