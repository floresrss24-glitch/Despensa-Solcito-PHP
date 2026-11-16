<?php
/**
 * includes/nav.php
 * Menú de navegación principal. Marca con la clase "active" la página actual
 * y muestra los avisos pendientes (por ejemplo: "Pedido registrado").
 *
 * Variables opcionales que puede definir la página:
 *   $ruta_base      Prefijo de rutas ("" o "../")
 *   $pagina_activa  Archivo a resaltar (útil en subcarpetas, ej: "producto.php")
 */
require_once __DIR__ . '/funciones.php';

$ruta_base = $ruta_base ?? '';

$menu = [
    'index.php'          => 'Inicio',
    'producto.php'       => 'Productos',
    'promociones.php'    => 'Promociones',
    'blog.php'           => 'Blog',
    'sobre_nosotros.php' => 'Sobre nosotros',
    'contactos.php'      => 'Contactos',
    'compras.php'        => 'Compras',
];

// Por defecto, la página activa es el archivo que se está ejecutando
$pagina_actual = $pagina_activa ?? basename($_SERVER['SCRIPT_NAME']);
?>
    <!-- MENÚ -->
    <nav class="navbar">
        <ul>
<?php foreach ($menu as $archivo => $texto): ?>
            <li><a href="<?= e($ruta_base . $archivo) ?>"<?= $archivo === $pagina_actual ? ' class="active" aria-current="page"' : '' ?>><?= e($texto) ?></a></li>
<?php endforeach; ?>
        </ul>
    </nav>
<?php foreach (flash_leer() as $aviso): ?>
    <div class="aviso aviso-<?= e($aviso['tipo']) ?>" role="status"><?= e($aviso['mensaje']) ?></div>
<?php endforeach; ?>
