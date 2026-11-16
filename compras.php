<?php
require_once __DIR__ . '/includes/auth.php';
require_once __DIR__ . '/includes/datos.php';

$categorias = obtener_categorias();
$entregas = ['domicilio' => 'Envío a domicilio', 'retiro' => 'Retiro en tienda'];
$errores = [];

if (es_post()) {
    $categoria = post('categoria');
    $cantidad = post('cantidad');
    $fecha = post('fecha');
    $entrega = post('entrega');
    $comentarios = post('comentarios');

    if (empty($_POST) && empty($_FILES) && (int) ($_SERVER['CONTENT_LENGTH'] ?? 0) > 0) {
        // PHP descarta todo el formulario si el archivo supera el límite del servidor
        $errores[] = 'El archivo adjunto es demasiado grande.';
    } elseif (!csrf_valido()) {
        $errores[] = 'La sesión expiró. Volvé a enviar el formulario.';
    } else {
        if (!isset($categorias[$categoria])) {
            $errores[] = 'Elegí una categoría de producto válida.';
        }

        if (filter_var($cantidad, FILTER_VALIDATE_INT, ['options' => ['min_range' => 1, 'max_range' => 50]]) === false) {
            $errores[] = 'La cantidad debe ser un número entero entre 1 y 50.';
        }

        if ($fecha !== '') {
            $fechaValida = DateTime::createFromFormat('Y-m-d', $fecha);

            if ($fechaValida === false || $fechaValida->format('Y-m-d') !== $fecha) {
                $errores[] = 'La fecha de entrega no es válida.';
            } elseif ($fecha < date('Y-m-d')) {
                $errores[] = 'La fecha de entrega no puede ser anterior a hoy.';
            }
        }

        if (!isset($entregas[$entrega])) {
            $errores[] = 'Elegí el tipo de entrega.';
        }

        if (largo($comentarios) > 500) {
            $errores[] = 'Los comentarios no pueden superar los 500 caracteres.';
        }

        if (post('terminos') !== 'aceptado') {
            $errores[] = 'Tenés que aceptar los términos y condiciones.';
        }

        // Comprobante de pago (opcional)
        $nombreComprobante = '';
        $adjunto = $_FILES['comprobante'] ?? null;

        if (count($errores) === 0 && $adjunto !== null && $adjunto['error'] !== UPLOAD_ERR_NO_FILE) {
            $resultado = guardar_comprobante($adjunto);

            if ($resultado['ok']) {
                $nombreComprobante = $resultado['nombre'];
            } else {
                $errores[] = $resultado['error'];
            }
        }

        if (count($errores) === 0) {
            $sesion = usuario_actual();
            $pedido = [
                'id'            => date('Ymd-His') . '-' . strtoupper(bin2hex(random_bytes(2))),
                'fecha'         => date('Y-m-d H:i:s'),
                'cliente'       => $sesion['correo'] ?? 'invitado',
                'categoria'     => $categoria,
                'cantidad'      => (int) $cantidad,
                'fecha_entrega' => $fecha,
                'entrega'       => $entrega,
                'comprobante'   => $nombreComprobante,
                'comentarios'   => $comentarios,
            ];

            if (storage_agregar_linea('pedidos.log', $pedido)) {
                $_SESSION['pedido_confirmado'] = $pedido;
                flash('exito', '¡Pedido registrado correctamente!');
                redirigir('compras.php');
            }

            $errores[] = 'No pudimos registrar el pedido. Intentá de nuevo más tarde.';
        }
    }
}

// Pedido recién confirmado (se muestra una sola vez)
$confirmado = $_SESSION['pedido_confirmado'] ?? null;
unset($_SESSION['pedido_confirmado']);

$titulo_pagina = 'Compras';
$hojas_estilo = ['css/style.css', 'css/compras.css'];
$scripts = ['js/funciones/validaciones.js', 'js/funciones/resumen-formulario.js', 'js/paginas/compras.js'];

require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/includes/nav.php';
?>
<main class="compras">

    <section class="compras-header">
        <h2>Realizar compra</h2>
        <p>Completá los datos para realizar tu pedido.</p>
    </section>

<?php if ($confirmado !== null): ?>
    <section class="resumen confirmacion" aria-live="polite">
        <h3>Pedido registrado</h3>
        <dl>
            <dt>Número de pedido</dt>
            <dd><?= e($confirmado['id']) ?></dd>
            <dt>Categoría</dt>
            <dd><?= e($categorias[$confirmado['categoria']]['nombre'] ?? $confirmado['categoria']) ?></dd>
            <dt>Cantidad</dt>
            <dd><?= e($confirmado['cantidad']) ?></dd>
            <dt>Tipo de entrega</dt>
            <dd><?= e($entregas[$confirmado['entrega']] ?? $confirmado['entrega']) ?></dd>
            <dt>Fecha deseada</dt>
            <dd><?= e($confirmado['fecha_entrega'] !== '' ? $confirmado['fecha_entrega'] : 'No indicada') ?></dd>
            <dt>Comprobante</dt>
            <dd><?= $confirmado['comprobante'] !== '' ? 'Adjuntado' : 'No adjuntado' ?></dd>
        </dl>
        <p class="resumen-aviso">Guardá el número de pedido por si necesitás consultarnos.</p>
    </section>
<?php endif; ?>

    <section class="pedido-card">

<?php if (count($errores) > 0): ?>
        <div class="mensaje-estado error" role="alert">
<?php foreach ($errores as $error): ?>
            <p><?= e($error) ?></p>
<?php endforeach; ?>
        </div>
<?php endif; ?>

        <form id="formPedido" action="compras.php" method="post" enctype="multipart/form-data" data-validar data-resumen="resumenPedido">
            <?= csrf_campo() ?>

            <input type="hidden" id="origen" name="origen" value="despensa">

            <fieldset>
                <legend>Detalle del pedido</legend>

                <div class="form-group">
                    <label for="categoria">Categoría de producto *</label>
                    <select id="categoria" name="categoria" required>
                        <option value="">-- Seleccioná una categoría --</option>
<?php foreach ($categorias as $clave => $cat): ?>
                        <option value="<?= e($clave) ?>"<?= post('categoria') === $clave ? ' selected' : '' ?>><?= e($cat['nombre']) ?></option>
<?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label for="cantidad">Cantidad *</label>
                    <input type="number" id="cantidad" name="cantidad" min="1" max="50" value="<?= es_post() ? old('cantidad') : '1' ?>" required>
                </div>

                <div class="form-group">
                    <label for="fecha">Fecha de entrega deseada</label>
                    <input type="date" id="fecha" name="fecha" value="<?= old('fecha') ?>">
                </div>

                <div class="form-group">
                    <span class="form-label">Tipo de entrega *</span>

                    <div class="radio-group">
                        <label>
                            <input type="radio" name="entrega" value="domicilio"<?= post('entrega') === 'domicilio' ? ' checked' : '' ?> required>
                            Envío a domicilio
                        </label>

                        <label>
                            <input type="radio" name="entrega" value="retiro"<?= post('entrega') === 'retiro' ? ' checked' : '' ?>>
                            Retiro en tienda
                        </label>
                    </div>
                </div>

                <div class="form-group">
                    <label for="comprobante">Adjuntar comprobante de pago <span>(opcional)</span></label>
                    <input type="file" id="comprobante" name="comprobante" accept=".jpg,.jpeg,.png,.pdf">
                </div>
            </fieldset>

            <div class="form-group">
                <label for="comentarios">Comentarios adicionales</label>
                <textarea id="comentarios" name="comentarios" rows="5" maxlength="500" placeholder="Indicá cualquier preferencia o consulta especial..."><?= old('comentarios') ?></textarea>
                <small id="contadorComentarios">Máximo 500 caracteres.</small>
            </div>

            <div class="checkbox-group">
                <input type="checkbox" id="terminos" name="terminos" value="aceptado"<?= post('terminos') === 'aceptado' ? ' checked' : '' ?> required>
                <label for="terminos">Acepto los términos y condiciones de <?= e(APP_NAME) ?>. *</label>
            </div>

            <div class="form-buttons">
                <button type="submit" class="btn-enviar">Enviar pedido</button>
                <button type="reset" class="btn-reset">Borrar</button>
            </div>

        </form>
    </section>

    <section class="resumen" id="resumenPedido" aria-live="polite" hidden></section>
</main>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
