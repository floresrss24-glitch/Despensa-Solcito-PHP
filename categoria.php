<?php
require_once __DIR__ . '/includes/auth.php';
require_once __DIR__ . '/includes/datos.php';

// La categoría llega por la URL: categoria.php?cat=snacks
// Solo se acepta si existe en el catálogo (nunca se usa el texto de la URL sin validar).
$categorias = obtener_categorias();
$clave = $_GET['cat'] ?? '';
$clave = is_string($clave) ? $clave : '';
$categoria = $categorias[$clave] ?? null;

// Agregar o quitar un producto de favoritos (formulario POST)
if ($categoria !== null && es_post()) {
    $usuario = usuario_actual();

    if (!csrf_valido()) {
        flash('error', 'La sesión expiró. Intentá de nuevo.');
    } elseif ($usuario === null) {
        flash('error', 'Iniciá sesión para guardar productos en tus favoritos.');
        redirigir('login.php');
    } else {
        $producto = obtener_producto(post('producto'));

        if ($producto !== null && $producto['categoria'] === $clave) {
            $esFavorito = alternar_favorito($usuario['correo'], $producto['id']);
            $accion = $esFavorito ? 'Agregaste' : 'Quitaste';
            $preposicion = $esFavorito ? 'a' : 'de';
            flash('exito', $accion . ' «' . $producto['nombre'] . '» ' . $preposicion . ' tus favoritos.');
        }
    }

    redirigir('categoria.php?cat=' . urlencode($clave) . '#productos');
}

// Si la categoría no existe se responde con el código HTTP 404
if ($categoria === null) {
    http_response_code(404);
}

$usuario = usuario_actual();
$favoritos = $usuario !== null ? favoritos_de($usuario['correo']) : [];

$titulo_pagina = $categoria['nombre'] ?? 'Categoría no encontrada';
$pagina_activa = 'producto.php';  // resalta "Productos" en el menú
$hojas_estilo = ['css/style.css', 'css/categoria.css'];
$scripts = ['js/funciones/galeria.js'];

require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/includes/nav.php';
?>
<?php if ($categoria === null): ?>
    <section class="categorias categoria-vacia">
        <h2>Categoría no encontrada</h2>
        <p>La categoría que buscás no existe o fue retirada.</p>
        <a href="producto.php" class="btn-categoria">Ver todos los productos</a>
    </section>
<?php else: ?>
    <section class="categorias" id="productos" data-galeria>
        <a href="producto.php" class="categoria-volver">← Todas las categorías</a>
        <h2><?= e($categoria['nombre']) ?></h2>
        <p class="categoria-descripcion"><?= e($categoria['descripcion']) ?></p>

        <div class="grid-categorias">
<?php foreach ($categoria['productos'] as $producto): ?>
<?php $esFavorito = in_array($producto['id'], $favoritos, true); ?>

            <div class="card producto">
<?php if (!empty($producto['imagen'])): ?>
                <div class="images <?= e($categoria['clase']) ?>">
                    <img src="<?= e($producto['imagen']) ?>" alt="<?= e($producto['nombre']) ?>">
                </div>
<?php else: ?>
                <div class="icon <?= e($categoria['clase']) ?>"><?= e($categoria['icono']) ?></div>
<?php endif; ?>
                <h3><?= e($producto['nombre']) ?></h3>
                <span><?= e(formato_precio($producto['precio'])) ?></span>

                <form method="post" action="categoria.php?cat=<?= e(urlencode($clave)) ?>" class="form-favorito">
                    <?= csrf_campo() ?>

                    <input type="hidden" name="producto" value="<?= e($producto['id']) ?>">
                    <button type="submit" class="btn-favorito<?= $esFavorito ? ' activo' : '' ?>" aria-pressed="<?= $esFavorito ? 'true' : 'false' ?>">
                        <?= $esFavorito ? '♥ En favoritos' : '♡ Agregar a favoritos' ?>
                    </button>
                </form>
            </div>
<?php endforeach; ?>

        </div>
    </section>
<?php endif; ?>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
