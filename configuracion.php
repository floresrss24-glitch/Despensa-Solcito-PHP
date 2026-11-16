<?php
$titulo_pagina = 'Configuración';
$hojas_estilo = ['css/configuracion.css'];
$scripts = ['js/paginas/configuracion.js'];
$mostrar_cabecera = false;
$mostrar_pie = false;

require_once __DIR__ . '/includes/header.php';
?>
    <header class="encabezado">
        <a href="index.php" class="marca">
            <i class="fa-solid fa-sun"></i>
            <span><?= e(APP_NAME) ?></span>
        </a>
        <a href="index.php" class="volver">
            <i class="fa-solid fa-arrow-left"></i> Volver
        </a>
    </header>

    <main class="contenedor">
        <div class="titulo">
            <h1>Configuración</h1>
            <p>Personalizá tu experiencia en <?= e(APP_NAME) ?>.</p>
        </div>

        <form id="formConfiguracion">

            <section class="panel">
                <h2><i class="fa-solid fa-user"></i> Datos del perfil</h2>

                <label for="nombre">Nombre</label>
                <input type="text" id="nombre" placeholder="Tu nombre">

                <label for="apellido">Apellido</label>
                <input type="text" id="apellido" placeholder="Tu apellido">

                <label for="correo">Correo electrónico</label>
                <input type="email" id="correo"
                       placeholder="ejemplo@correo.com">
            </section>

            <section class="panel">
                <h2><i class="fa-solid fa-palette"></i> Apariencia</h2>

                <div class="opcion">
                    <div>
                        <strong>Modo oscuro</strong>
                        <p>Cambiar los colores de la página.</p>
                    </div>
                    <input type="checkbox" id="modoOscuro">
                </div>
            </section>

            <section class="panel">
                <h2><i class="fa-solid fa-bell"></i> Notificaciones</h2>

                <div class="opcion">
                    <div>
                        <strong>Promociones</strong>
                        <p>Recibir avisos sobre ofertas.</p>
                    </div>
                    <input type="checkbox" id="notificacionesPromos">
                </div>

                <div class="opcion">
                    <div>
                        <strong>Novedades</strong>
                        <p>Recibir información sobre productos nuevos.</p>
                    </div>
                    <input type="checkbox" id="notificacionesNovedades">
                </div>
            </section>

            <section class="panel">
                <h2><i class="fa-solid fa-shield-halved"></i> Seguridad</h2>

                <p class="aviso">
                    La contraseña se administra desde el sistema de cuentas.
                    Esta página todavía no tiene autenticación conectada.
                </p>

                <a href="login.php" class="enlace">
                    Ir al inicio de sesión
                </a>
            </section>

            <div class="acciones">
                <button type="submit" class="guardar">
                    <i class="fa-solid fa-floppy-disk"></i>
                    Guardar configuración
                </button>

                <button type="button" id="restablecer" class="restablecer">
                    Restablecer
                </button>
            </div>

            <p id="mensaje" role="status" aria-live="polite"></p>
        </form>
    </main>

    <footer>
        © 2026 <?= e(APP_NAME) ?>
    </footer>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
