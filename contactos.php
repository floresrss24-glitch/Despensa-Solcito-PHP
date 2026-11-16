<?php
require_once __DIR__ . '/includes/funciones.php';

$errores = [];

if (es_post()) {
    $nombre = post('nombre');
    $correo = post('correo');
    $asunto = post('asunto');
    $mensaje = post('mensaje');

    if (!csrf_valido()) {
        $errores[] = 'La sesión expiró. Volvé a enviar el formulario.';
    } else {
        if (largo($nombre) < 2 || largo($nombre) > 100) {
            $errores[] = 'Ingresá tu nombre (entre 2 y 100 caracteres).';
        }

        if (!correo_valido($correo)) {
            $errores[] = 'Ingresá un correo electrónico válido.';
        }

        if (largo($asunto) > 150) {
            $errores[] = 'El asunto no puede superar los 150 caracteres.';
        }

        if (largo($mensaje) < 10 || largo($mensaje) > 2000) {
            $errores[] = 'El mensaje debe tener entre 10 y 2000 caracteres.';
        }

        if (count($errores) === 0) {
            $guardado = storage_agregar_linea('mensajes.log', [
                'fecha'   => date('Y-m-d H:i:s'),
                'nombre'  => $nombre,
                'correo'  => $correo,
                'asunto'  => $asunto,
                'mensaje' => $mensaje,
            ]);

            if ($guardado) {
                flash('exito', '¡Gracias, ' . $nombre . '! Recibimos tu mensaje.');
                redirigir('contactos.php');
            }

            $errores[] = 'No pudimos guardar tu mensaje. Intentá de nuevo más tarde.';
        }
    }
}
$titulo_pagina = 'Contactos';
$hojas_estilo = ['css/style.css', 'css/contactos.css'];
$scripts = ['js/funciones/validaciones.js', 'js/paginas/contactos.js'];

require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/includes/nav.php';
?>
    <!-- CONTACTO -->
    <section class="contact-header">
        <h1>Contáctanos</h1>
        <p>Estamos para ayudarte. Comunícate con nosotros cuando lo necesites.</p>
    </section>

    <section class="contact-container">

        <!-- INFORMACIÓN -->
        <div class="contact-info">

            <h2>Información de Contacto</h2>

            <div class="info-item">
                <i class="fas fa-map-marker-alt"></i>
                <div>
                    <h3>Dirección</h3>
                    <p>Av. Principal 123, Salta, Argentina</p>
                </div>
            </div>

            <div class="info-item">
                <i class="fas fa-phone"></i>
                <div>
                    <h3>Teléfono</h3>
                    <p>+54 387 123 4567</p>
                </div>
            </div>

            <div class="info-item">
                <i class="fas fa-envelope"></i>
                <div>
                    <h3>Email</h3>
                    <p><?= e(APP_EMAIL) ?></p>
                </div>
            </div>

            <div class="info-item">
                <i class="fas fa-clock"></i>
                <div>
                    <h3>Horario</h3>
                    <p>Lunes a Sábado: 08:00 - 22:00</p>
                </div>
            </div>

            <div class="social-contact">
                <a href="#"><i class="fab fa-facebook-f"></i></a>
                <a href="#"><i class="fab fa-instagram"></i></a>
                <a href="#"><i class="fab fa-whatsapp"></i></a>
            </div>

        </div>

        <!-- FORMULARIO -->
        <div class="contact-form">

            <h2>Envíanos un mensaje</h2>

            <form id="formContacto" method="post" action="contactos.php" data-validar>
                <?= csrf_campo() ?>


                <div class="campo">
                    <input type="text" id="nombre" name="nombre" placeholder="Nombre completo" aria-label="Nombre completo" maxlength="100" required value="<?= old('nombre') ?>">
                </div>

                <div class="campo">
                    <input type="email" id="correo" name="correo" placeholder="Correo electrónico" aria-label="Correo electrónico" maxlength="120" required value="<?= old('correo') ?>">
                </div>

                <div class="campo">
                    <input type="text" id="asunto" name="asunto" placeholder="Asunto" aria-label="Asunto" maxlength="150" value="<?= old('asunto') ?>">
                </div>

                <div class="campo">
                    <textarea id="mensaje" name="mensaje" rows="6" placeholder="Escribe tu mensaje" aria-label="Mensaje" maxlength="2000" required><?= old('mensaje') ?></textarea>
                </div>

                <button type="submit">Enviar Mensaje</button>

                <div id="mensajeContacto" class="mensaje-estado error" role="alert" aria-live="polite">
<?php foreach ($errores as $error): ?>
                    <p><?= e($error) ?></p>
<?php endforeach; ?>
                </div>

            </form>

        </div>

    </section>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
