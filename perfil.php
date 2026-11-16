<?php
require_once __DIR__ . '/includes/auth.php';

requerir_login('Iniciá sesión para ver tu perfil.');
$sesion = usuario_actual();
$errores = [];

// Cambiar el nombre (formulario POST)
if (es_post()) {
    $nombre = post('nombre');

    if (!csrf_valido()) {
        $errores[] = 'La sesión expiró. Intentá de nuevo.';
    } elseif (largo($nombre) < 2 || largo($nombre) > 60) {
        $errores[] = 'El nombre debe tener entre 2 y 60 caracteres.';
    } elseif (!actualizar_nombre($sesion['correo'], $nombre)) {
        $errores[] = 'No se pudo guardar el cambio. Intentá de nuevo.';
    } else {
        flash('exito', 'Actualizaste tu nombre correctamente.');
        redirigir('perfil.php');
    }
}

$usuario = usuario_por_correo($sesion['correo']);

$titulo_pagina = 'Mi perfil';
$hojas_estilo = ['css/style.css', 'css/perfil.css'];

require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/includes/nav.php';
?>
    <main class="perfil">

        <section class="perfil-card">
            <div class="perfil-cabecera">
                <img src="img/iconos/usuario.png" alt="Foto de perfil">
                <div>
                    <h2><?= e($usuario['nombre'] ?? $sesion['nombre']) ?></h2>
                    <p><?= e($sesion['correo']) ?></p>
                </div>
            </div>

            <dl class="perfil-datos">
                <dt>Cliente desde</dt>
                <dd><?= e(substr($usuario['creado'] ?? '', 0, 10)) ?></dd>

                <dt>Productos favoritos</dt>
                <dd><?= count($usuario['favoritos'] ?? []) ?></dd>
            </dl>
        </section>

        <section class="perfil-card">
            <h3>Editar nombre</h3>

<?php if (count($errores) > 0): ?>
            <div class="mensaje-estado error" role="alert">
<?php foreach ($errores as $error): ?>
                <p><?= e($error) ?></p>
<?php endforeach; ?>
            </div>
<?php endif; ?>

            <form method="post" action="perfil.php" class="perfil-form">
                <?= csrf_campo() ?>

                <label for="nombre">Nombre</label>
                <input type="text" id="nombre" name="nombre" maxlength="60" required
                       value="<?= es_post() ? old('nombre') : e($usuario['nombre'] ?? '') ?>">

                <button type="submit" class="btn-perfil">Guardar cambios</button>
            </form>

            <p class="perfil-enlaces">
                <a href="favoritos.php">Ver mis favoritos</a> ·
                <a href="configuracion.php">Configuración</a> ·
                <a href="logout.php">Cerrar sesión</a>
            </p>
        </section>

    </main>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
