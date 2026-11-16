<?php
/**
 * includes/header.php
 * Abre el documento HTML: <head>, hojas de estilo y cabecera del sitio.
 *
 * Variables que cada página puede definir ANTES de incluir este archivo:
 *   $titulo_pagina    Título de la pestaña (por defecto "Inicio")
 *   $hojas_estilo     Lista de archivos CSS (por defecto css/style.css)
 *   $ruta_base        Prefijo de rutas: "" en la raíz, "../" en subcarpetas
 *   $mostrar_cabecera false para páginas con su propia cabecera (login)
 */
require_once __DIR__ . '/auth.php';  // carga también config/env.php y la sesión

$titulo_pagina = $titulo_pagina ?? 'Inicio';
$hojas_estilo = $hojas_estilo ?? ['css/style.css'];
$ruta_base = $ruta_base ?? '';
$mostrar_cabecera = $mostrar_cabecera ?? true;
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= e($titulo_pagina) ?> | <?= e(APP_NAME) ?></title>
<?php foreach ($hojas_estilo as $hoja): ?>
    <link rel="stylesheet" href="<?= e($ruta_base . $hoja) ?>">
<?php endforeach; ?>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>
<body>
<?php if ($mostrar_cabecera): ?>
<?php $usuario_sesion = usuario_actual(); ?>
    <!-- HEADER PRINCIPAL -->
    <header class="top-header">
        <div class="logo">
            <img src="<?= e($ruta_base) ?>img/marca/despensa-solcito.png" alt="Logo de <?= e(APP_NAME) ?>">
            <h1><?= e(APP_NAME) ?></h1>
        </div>

        <div class="dropdown-menu">
            <!-- Botón que abre el menú -->
            <button class="dropdown-toggle" id="perfilBoton"
                    aria-expanded="false"
                    aria-controls="perfilMenu"
                    type="button">

                <i class="fas fa-user-circle"></i>
                <span>Mi perfil</span>
                <i class="fas fa-chevron-down flecha"></i>
            </button>

            <!-- Contenido desplegable -->
            <div class="dropdown-wrapper" id="perfilMenu" hidden>
                <!-- Información del usuario -->
                <div class="user-info">
                    <img src="<?= e($ruta_base) ?>img/iconos/usuario.png" alt="Foto de perfil">
                    <div>
                        <h2<?= $usuario_sesion === null ? ' data-invitado' : '' ?>><?= e($usuario_sesion['nombre'] ?? 'Tu nombre') ?></h2>
                        <p><?= e($usuario_sesion['correo'] ?? 'Mi cuenta') ?></p>
                    </div>
                </div>

                <hr>
                <!-- Opciones del menú -->
                <div class="menu-options">
                    <a href="<?= e($ruta_base) ?>perfil.php">
                        <img src="<?= e($ruta_base) ?>img/iconos/usuario.png" alt="Perfil">
                        <p>Mi perfil</p>
                        <span></span>
                    </a>
                    <a href="<?= e($ruta_base) ?>compras.php">
                        <img src="<?= e($ruta_base) ?>img/iconos/carrito.png" alt="Compras">
                        <p>Mis compras</p>
                        <span></span>
                    </a>
                    <a href="<?= e($ruta_base) ?>favoritos.php">
                        <img src="<?= e($ruta_base) ?>img/iconos/favoritos.png" alt="Productos favoritos">
                        <p>Productos Favoritos</p>
                        <span></span>
                    </a>
                    <a href="<?= e($ruta_base) ?>configuracion.php">
                        <img src="<?= e($ruta_base) ?>img/iconos/config.png" alt="Configuración">
                        <p>Configuración</p>
                        <span></span>
                    </a>
                    <a href="<?= e($ruta_base) ?>ayuda.php">
                        <img src="<?= e($ruta_base) ?>img/iconos/soporte.png" alt="Ayuda y soporte">
                        <p>Ayuda y soporte</p>
                        <span></span>
                    </a>
                    <a href="<?= e($ruta_base) ?>contactos.php">
                        <img src="<?= e($ruta_base) ?>img/iconos/contacto.png" alt="Contacto">
                        <p>Contacto</p>
                        <span></span>
                    </a>
                    <hr>

<?php if ($usuario_sesion === null): ?>
                    <a href="<?= e($ruta_base) ?>login.php" class="cerrar-sesion">
                        <img src="<?= e($ruta_base) ?>img/iconos/sesion.png" alt="Iniciar sesión">
                        <p>Iniciar sesión</p>
                        <span></span>
                    </a>
<?php else: ?>
                    <a href="<?= e($ruta_base) ?>logout.php" class="cerrar-sesion">
                        <img src="<?= e($ruta_base) ?>img/iconos/sesion.png" alt="Cerrar sesión">
                        <p>Cerrar sesión</p>
                        <span></span>
                    </a>
<?php endif; ?>
                </div>
            </div>
        </div>
    </header>
<?php endif; ?>
