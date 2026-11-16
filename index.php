<?php
$titulo_pagina = 'Inicio';
$hojas_estilo = ['css/style.css'];
$scripts = ['js/funciones/fecha-hora.js', 'js/funciones/alerta.js', 'js/paginas/inicio.js'];

require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/includes/nav.php';
?>
    <!-- Fecha y hora actual -->
    <div class="fecha-hora">
        <p id="fechaActual"></p>
        <p id="horaActual"></p>
    </div>

    <!-- HERO -->
    <section class="hero">
        <div class="hero-image">
            <img 
                src="img/fotos/local.webp"
                srcset="
                    img/fotos/local.webp 400w,
                    img/fotos/local.webp 800w,
                    img/fotos/local.webp 1200w
                "
                sizes="(max-width: 600px) 100vw, 600px"
                alt="Descripción de la imagen"
                width="800"
                height="450"
                fetchpriority="high"
            >
        </div>

        <div class="hero-content">
            <h2>Bienvenido a la <br><?= e(APP_NAME) ?></h2>
            <p>
                Encuentra todo lo que necesitas para tu hogar.
                Los mejores productos de abarrotes, bebidas,
                snacks y mucho más. Calidad garantizada y
                precios accesibles para toda la familia.
            </p>
            <a href="producto.php" class="btn">Ver Productos</a>
        </div>
    </section>

    <!-- CATEGORÍAS -->
    <section class="categorias">
        <h2>Categorías</h2>
        <div class="grid-categorias">
            <div class="card">
                <div class="icon bebida">🥤</div>
                <h3>Bebidas</h3>
                <p>Refrescos, jugos y más</p>
                <span>$25.00</span>
            </div>
            <div class="card">
                <div class="icon pan">🍞</div>
                <h3>Panadería</h3>
                <p>Pan fresco diario</p>
                <span>$15.00</span>
            </div>
            <div class="card">
                <div class="icon abarrotes">🥫</div>
                <h3>Abarrotes</h3>
                <p>Productos de despensa</p>
                <span>$35.00</span>
            </div>
            <div class="card">
                <div class="icon snacks">🍪</div>
                <h3>Snacks</h3>
                <p>Botanas y dulces</p>
                <span>$20.00</span>
            </div>
            <div class="card">
                <div class="icon lacteos">🧃</div>
                <h3>Lácteos</h3>
                <p>Leche, yogurt, queso</p>
                <span>$30.00</span>
            </div>
            <div class="card">
                <div class="icon pastas">🍝</div>
                <h3>Pastas</h3>
                <p>Variedad de pastas</p>
                <span>$18.00</span>
            </div>
            <div class="card">
                <div class="icon limpieza">🧽</div>
                <h3>Limpieza</h3>
                <p>Productos de limpieza</p>
                <span>$45.00</span>
            </div>
            <div class="card">
                <div class="icon congelados">❄️</div>
                <h3>Congelados</h3>
                <p>Productos congelados</p>
                <span>$55.00</span>
            </div>
        </div>
    </section>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
