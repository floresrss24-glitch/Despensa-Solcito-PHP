<?php
require_once __DIR__ . '/includes/auth.php';

// Si ya hay una sesión iniciada, no tiene sentido ver el login
if (usuario_actual() !== null) {
    redirigir('index.php');
}

$errores = [];

if (es_post()) {
    $correo = post('correo');
    $contrasena = post_crudo('contrasena');

    if (!csrf_valido()) {
        $errores[] = 'La sesión expiró. Intentá de nuevo.';
    } elseif ($correo === '' || $contrasena === '') {
        $errores[] = 'Completá el correo y la contraseña.';
    } else {
        $usuario = verificar_credenciales($correo, $contrasena);

        if ($usuario === null) {
            // El mensaje es el mismo si falla el correo o la contraseña
            $errores[] = 'El correo o la contraseña son incorrectos.';
        } else {
            iniciar_sesion($usuario);
            flash('exito', '¡Hola de nuevo, ' . $usuario['nombre'] . '!');
            redirigir('index.php');
        }
    }
}

// Avisos que vienen de otra página (por ejemplo: "Iniciá sesión para ver tu perfil")
$avisos = flash_leer();

$titulo_pagina = 'Iniciar sesión';
$hojas_estilo = ['css/login.css'];
$scripts = ['js/paginas/login.js'];
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
                <p>¡Qué bueno verte de nuevo!</p>
            </div>

            <div class="login-titulo">
                <h2>Iniciar sesión</h2>
                <p>Ingresá tus datos para continuar.</p>
            </div>

            <form id="formLogin" method="post" action="login.php" novalidate>
                <?= csrf_campo() ?>

                <div class="campo">
                    <label for="correo">Correo electrónico:</label>
                    <div class="input-icono">
                        <i class="fa-regular fa-envelope"></i>
                        <input type="email" id="correo" name="correo" autocomplete="email" placeholder="ejemplo@correo.com" value="<?= old('correo') ?>">
                    </div>
                    <p class="error-campo" id="errorCorreo" role="alert"></p>
                </div>

                <div class="campo">
                    <label for="contrasena">Contraseña:</label>
                    <div class="input-icono">
                        <i class="fa-solid fa-lock"></i>
                        <input type="password" id="contrasena" name="contrasena" autocomplete="current-password" placeholder="Tu contraseña">
                        <button type="button" id="mostrarContrasena" class="mostrar-contrasena" aria-label="Mostrar contraseña">
                            <i class="fa-regular fa-eye"></i>
                        </button>
                    </div>
                    <p class="error-campo" id="errorContrasena" role="alert"></p>
                </div>

                <button type="submit" class="boton-login">Ingresar</button>

                <div id="mensajeLogin" aria-live="polite">
<?php foreach ($errores as $error): ?>
                    <p class="mensaje error"><?= e($error) ?></p>
<?php endforeach; ?>
<?php foreach ($avisos as $aviso): ?>
                    <p class="mensaje<?= $aviso['tipo'] === 'error' ? ' error' : '' ?>"><?= e($aviso['mensaje']) ?></p>
<?php endforeach; ?>
                </div>

            </form>

            <div class="separador">
                <span>¿Todavía no tenés una cuenta?</span>
            </div>

            <a href="registro.php" class="boton-registro">
                Crear una cuenta
            </a>

        </div>

        <p class="pie-login">
            © <?= date('Y') ?> <?= e(APP_NAME) ?>. Todos los derechos reservados.
        </p>

    </main>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
