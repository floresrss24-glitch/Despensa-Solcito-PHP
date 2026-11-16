<?php
require_once __DIR__ . '/includes/datos.php';

$titulo_pagina = 'Productos';
$hojas_estilo = ['css/style.css'];

require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/includes/nav.php';
?>
    <section class="categorias">
        <h2>Todos nuestros productos</h2>

        <div class="grid-categorias">
<?php foreach (obtener_categorias() as $clave => $categoria): ?>

            <a href="categoria.php?cat=<?= e($clave) ?>" class="card">
                <div class="icon <?= e($categoria['clase']) ?>"><?= e($categoria['icono']) ?></div>
                <h3><?= e($categoria['nombre']) ?></h3>
                <p><?= e($categoria['descripcion']) ?></p>
            </a>
<?php endforeach; ?>

        </div>
    </section>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
