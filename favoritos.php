<?php
require_once __DIR__ . '/includes/auth.php';
require_once __DIR__ . '/includes/datos.php';

requerir_login('Iniciá sesión para ver tus productos favoritos.');
$usuario = usuario_actual();

// Quitar un producto de la lista (formulario POST)
if (es_post()) {
    $producto = obtener_producto(post('producto'));

    if (!csrf_valido()) {
        flash('error', 'La sesión expiró. Intentá de nuevo.');
    } elseif ($producto !== null) {
        quitar_favorito($usuario['correo'], $producto['id']);
        flash('exito', 'Quitaste «' . $producto['nombre'] . '» de tus favoritos.');
    }

    redirigir('favoritos.php');
}

// Se arma la lista de productos a partir de los ids guardados
$productos = [];
foreach (favoritos_de($usuario['correo']) as $id) {
    $producto = obtener_producto($id);

    if ($producto !== null) {
        $productos[] = $producto;
    }
}

$categorias = obtener_categorias();

$titulo_pagina = 'Productos favoritos';
$hojas_estilo = ['css/style.css', 'css/categoria.css'];

require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/includes/nav.php';
?>
    <section class="categorias">
        <h2>Productos favoritos</h2>
        <p class="categoria-descripcion">Los productos que guardaste, <?= e($usuario['nombre']) ?>.</p>

<?php if (count($productos) === 0): ?>
        <p>Todavía no guardaste ningún producto.</p>
        <a href="producto.php" class="btn-categoria">Explorar productos</a>
<?php else: ?>
        <div class="grid-categorias">
<?php foreach ($productos as $producto): ?>
<?php $categoria = $categorias[$producto['categoria']]; ?>

            <div class="card producto">
                <div class="icon <?= e($categoria['clase']) ?>"><?= e($categoria['icono']) ?></div>
                <h3><?= e($producto['nombre']) ?></h3>
                <p><?= e($categoria['nombre']) ?></p>
                <span><?= e(formato_precio($producto['precio'])) ?></span>

                <form method="post" action="favoritos.php" class="form-favorito">
                    <?= csrf_campo() ?>

                    <input type="hidden" name="producto" value="<?= e($producto['id']) ?>">
                    <button type="submit" class="btn-favorito activo">Quitar de favoritos</button>
                </form>
            </div>
<?php endforeach; ?>

        </div>
<?php endif; ?>
    </section>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
