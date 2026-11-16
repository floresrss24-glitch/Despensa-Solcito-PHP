<?php
/**
 * includes/footer.php
 * Pie de página, scripts de JavaScript y cierre del documento HTML.
 *
 * Variables opcionales que puede definir la página:
 *   $scripts      Lista de archivos JS propios de la página
 *   $ruta_base    Prefijo de rutas ("" o "../")
 *   $mostrar_pie  false para páginas con su propio pie (login, configuración)
 */
$scripts = $scripts ?? [];
$ruta_base = $ruta_base ?? '';
$mostrar_pie = $mostrar_pie ?? true;
?>
<?php if ($mostrar_pie): ?>

    <footer class="footer">

        <div class="footer-container">
            <div class="footer-section">
                <h3><?= e(APP_NAME) ?></h3>
                <p>
                    Tu tienda de confianza para encontrar
                    productos de calidad al mejor precio.
                </p>
            </div>
            <div class="footer-section">
                <h3>Enlaces</h3>
                <ul>
                    <li><a href="<?= e($ruta_base) ?>index.php">Inicio</a></li>
                    <li><a href="<?= e($ruta_base) ?>producto.php">Productos</a></li>
                    <li><a href="<?= e($ruta_base) ?>producto.php">Categorías</a></li>
                    <li><a href="<?= e($ruta_base) ?>promociones.php">Ofertas</a></li>
                    <li><a href="<?= e($ruta_base) ?>cv.php">Presenta tu CV para trabajar con nosotros</a></li>
                    <li><a href="<?= e($ruta_base) ?>preguntas_frecuentes.php">Preguntas Frecuentes</a></li>
                    <li><a href="<?= e($ruta_base) ?>curso.php">Curso</a></li>
                </ul>
            </div>
            <div class="footer-section">
                <h3>Contacto</h3>
                <p>📍 Salta, Argentina</p>
                <p>📞 +54 387 123-4567</p>
                <p>✉ <?= e(APP_EMAIL) ?></p>
            </div>
            <div class="footer-section">
                <h3>Síguenos</h3>
                <div class="social-icons">
                    <a href="#" aria-label="Facebook">
                        <i class="fab fa-facebook-f"></i>
                    </a>
                    <a href="#" aria-label="Instagram">
                        <i class="fab fa-instagram"></i>
                    </a>
                    <a href="#" aria-label="WhatsApp">
                        <i class="fab fa-whatsapp"></i>
                    </a>
                </div>
            </div>
        </div>
        <div class="footer-bottom">
            <p>© <?= date('Y') ?> <?= e(APP_NAME) ?> | Todos los derechos reservados.</p>
        </div>
    </footer>
<?php endif; ?>

    <!-- Scripts comunes a todo el sitio -->
    <script src="<?= e($ruta_base) ?>js/funciones/tema.js"></script>
    <script src="<?= e($ruta_base) ?>js/funciones/menus.js"></script>
<?php foreach ($scripts as $script): ?>
    <script src="<?= e($ruta_base . $script) ?>"></script>
<?php endforeach; ?>
</body>
</html>
