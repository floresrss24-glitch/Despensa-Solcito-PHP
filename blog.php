<?php
$titulo_pagina = 'Blog';
$hojas_estilo = ['css/style.css', 'css/blog.css'];

require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/includes/nav.php';
?>
    <!-- TÍTULO -->
    <section class="blog-header">
        <h1>Blog de <?= e(APP_NAME) ?></h1>
        <p>Noticias, recetas, consejos y promociones para toda la familia.</p>
    </section>
    <!-- ENTRADAS -->
    <section class="blog-container">

        <article class="blog-card">
            <img src="img/blog1.jpg" alt="Consejos de ahorro">

            <div class="blog-content">
                <h2>5 Consejos para ahorrar en tus compras</h2>

                <p>
                    Descubre cómo organizar tus compras semanales
                    y aprovechar las promociones para ahorrar dinero.
                </p>

                <a href="#" class="blog-btn">Leer más</a>
            </div>
        </article>

        <article class="blog-card">
            <img src="img/blog2.jpg" alt="Recetas">

            <div class="blog-content">
                <h2>Recetas rápidas para toda la familia</h2>

                <p>
                    Ideas sencillas utilizando productos que puedes
                    encontrar en nuestra despensa.
                </p>

                <a href="#" class="blog-btn">Leer más</a>
            </div>
        </article>

        <article class="blog-card">
            <img src="img/blog3.jpg" alt="Promociones">

            <div class="blog-content">
                <h2>Nuevas promociones de la semana</h2>

                <p>
                    Aprovecha descuentos especiales en bebidas,
                    golosinas y productos de limpieza.
                </p>

                <a href="#" class="blog-btn">Leer más</a>
            </div>
        </article>
    </section>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
