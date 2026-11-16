<?php
require_once __DIR__ . '/includes/auth.php';

if (usuario_actual() !== null) {
    redirigir('index.php');
}

$errores = [];

if (es_post()) {
    $nombre = post('nombre');
    $correo = post('correo');
    $contrasena = post_crudo('contrasena');
    $confirmar = post_crudo('confirmar');

    if (!csrf_valido()) {
        $errores[] = 'La sesión expiró. Intentá de nuevo.';
    } else {
        if (largo($nombre) < 2 || largo($nombre) > 60) {
            $errores[] = 'El nombre debe tener entre 2 y 60 caracteres.';
        }

        if (!correo_valido($correo)) {
            $errores[] = 'Ingresá un correo electrónico válido.';
        }

        if (strlen($contrasena) < 8) {
            $errores[] = 'La contraseña debe tener al menos 8 caracteres.';
        } elseif ($contrasena !== $confirmar) {
            $errores[] = 'Las contraseñas no coinciden.';
        }

        if (count($errores) === 0) {
            if (usuario_por_correo($correo) !== null) {
                $errores[] = 'Ya existe una cuenta con ese correo.';
            } else {
                $usuario = registrar_usuario($nombre, $correo, $contrasena);

                if ($usuario === null) {
                    $errores[] = 'No se pudo crear la cuenta. Intentá de nuevo.';
                } else {
                    iniciar_sesion($usuario);
                    flash('exito', '¡Cuenta creada! Bienvenido/a, ' . $usuario['nombre'] . '.');
                    redirigir('index.php');
                }
            }
        }
    }
}

$titulo_pagina = 'Crear cuenta';
$hojas_estilo = ['css/login.css'];
$mostrar_cabecera = false;
$mostrar_pie = false;

require_once __DIR__ . '/includes/header.php';
?>
    <main class="login-container">

        <a href="index.php" class="volver-inicio">
            <i class="fa-solid fa-arrow-left"></i> Volver al inicio
        </a>

        <div class="login-card">

            <div class="logo">
                <div class="logo-icono">
                    <i class="fa-solid fa-sun"></i>
                </div>
                <h1>Despensa <span>Solcito</span></h1>
                <p>¡Bienvenido/a a la familia!</p>
            </div>

            <div class="login-titulo">
                <h2>Crear cuenta</h2>
                <p>Completá tus datos para registrarte.</p>
            </div>

<?php if (count($errores) > 0): ?>
            <ul class="lista-errores" role="alert">
<?php foreach ($errores as $error): ?>
                <li><?= e($error) ?></li>
<?php endforeach; ?>
            </ul>
<?php endif; ?>

            <form id="formRegistro" method="post" action="registro.php">
                <?= csrf_campo() ?>

                <div class="campo">
                    <label for="nombre">Nombre:</label>
                    <div class="input-icono">
                        <i class="fa-regular fa-user"></i>
                        <input type="text" id="nombre" name="nombre" autocomplete="name" placeholder="Tu nombre" maxlength="60" required value="<?= old('nombre') ?>">
                    </div>
                </div>

                <div class="campo">
                    <label for="correo">Correo electrónico:</label>
                    <div class="input-icono">
                        <i class="fa-regular fa-envelope"></i>
                        <input type="email" id="correo" name="correo" autocomplete="email" placeholder="ejemplo@correo.com" maxlength="120" required value="<?= old('correo') ?>">
                    </div>
                </div>

                <div class="campo">
                    <label for="contrasena">Contraseña (mínimo 8 caracteres):</label>
                    <div class="input-icono">
                        <i class="fa-solid fa-lock"></i>
                        <input type="password" id="contrasena" name="contrasena" autocomplete="new-password" placeholder="Elegí una contraseña" minlength="8" required>
                    </div>
                </div>

                <div class="campo">
                    <label for="confirmar">Repetir contraseña:</label>
                    <div class="input-icono">
                        <i class="fa-solid fa-lock"></i>
                        <input type="password" id="confirmar" name="confirmar" autocomplete="new-password" placeholder="Repetí la contraseña" minlength="8" required>
                    </div>
                </div>

                <button type="submit" class="boton-login">Crear cuenta</button>

            </form>

            <div class="separador">
                <span>¿Ya tenés una cuenta?</span>
            </div>

            <a href="login.php" class="boton-registro">
                Iniciar sesión
            </a>

        </div>

        <p class="pie-login">
            © <?= date('Y') ?> <?= e(APP_NAME) ?>. Todos los derechos reservados.
        </p>

    </main>

<?php require_once __DIR__ . '/includes/footer.php'; ?>