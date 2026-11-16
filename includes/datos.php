<?php
/**
 * includes/datos.php
 * Catálogo de categorías y productos de ejemplo.
 * Cuando exista una base de datos, estas funciones leerán de ahí.
 */

/** Categorías con sus productos. La clave de cada una se usa en la URL: categoria.php?cat=snacks */
function obtener_categorias(): array
{
    $categorias = [
        'bebidas' => [
            'nombre' => 'Bebidas', 'descripcion' => 'Refrescos, jugos y más',
            'icono' => '🥤', 'clase' => 'bebida',
            'productos' => [
                ['nombre' => 'Coca Cola', 'precio' => 25.00, 'imagen' => 'img/productos/coca-cola.png'],
                ['nombre' => 'Pepsi', 'precio' => 15.00, 'imagen' => 'img/productos/pepsi.png'],
                ['nombre' => 'Jugo de naranja 1 L', 'precio' => 18.00],
                ['nombre' => 'Agua mineral 2 L', 'precio' => 10.00],
            ],
        ],
        'panaderia' => [
            'nombre' => 'Panadería', 'descripcion' => 'Pan fresco diario',
            'icono' => '🍞', 'clase' => 'pan',
            'productos' => [
                ['nombre' => 'Pan francés (kg)', 'precio' => 6.50],
                ['nombre' => 'Facturas x6', 'precio' => 9.00],
                ['nombre' => 'Pan de molde', 'precio' => 7.50],
                ['nombre' => 'Medialunas x6', 'precio' => 8.00],
            ],
        ],
        'abarrotes' => [
            'nombre' => 'Abarrotes', 'descripcion' => 'Productos de despensa',
            'icono' => '🥫', 'clase' => 'abarrotes',
            'productos' => [
                ['nombre' => 'Arroz 1 kg', 'precio' => 3.50],
                ['nombre' => 'Aceite de girasol 900 ml', 'precio' => 8.00],
                ['nombre' => 'Azúcar 1 kg', 'precio' => 4.00],
                ['nombre' => 'Harina 000 1 kg', 'precio' => 2.50],
            ],
        ],
        'snacks' => [
            'nombre' => 'Snacks', 'descripcion' => 'Botanas y dulces',
            'icono' => '🍪', 'clase' => 'snacks',
            'productos' => [
                ['nombre' => 'Papas fritas 150 g', 'precio' => 5.50],
                ['nombre' => 'Galletitas surtidas', 'precio' => 4.00],
                ['nombre' => 'Maní salado 200 g', 'precio' => 3.00],
                ['nombre' => 'Alfajor triple', 'precio' => 2.50],
            ],
        ],
        'lacteos' => [
            'nombre' => 'Lácteos', 'descripcion' => 'Leche, yogurt, queso',
            'icono' => '🧃', 'clase' => 'lacteos',
            'productos' => [
                ['nombre' => 'Leche entera 1 L', 'precio' => 2.80],
                ['nombre' => 'Yogur natural', 'precio' => 1.50],
                ['nombre' => 'Queso cremoso (kg)', 'precio' => 12.00],
                ['nombre' => 'Manteca 200 g', 'precio' => 4.50],
            ],
        ],
        'pastas' => [
            'nombre' => 'Pastas', 'descripcion' => 'Variedad de pastas',
            'icono' => '🍝', 'clase' => 'pastas',
            'productos' => [
                ['nombre' => 'Fideos tirabuzón 500 g', 'precio' => 2.20],
                ['nombre' => 'Spaghetti 500 g', 'precio' => 2.20],
                ['nombre' => 'Ravioles 500 g', 'precio' => 6.00],
                ['nombre' => 'Ñoquis 500 g', 'precio' => 5.00],
            ],
        ],
        'limpieza' => [
            'nombre' => 'Limpieza', 'descripcion' => 'Productos de limpieza',
            'icono' => '🧽', 'clase' => 'limpieza',
            'productos' => [
                ['nombre' => 'Detergente 750 ml', 'precio' => 3.20],
                ['nombre' => 'Lavandina 1 L', 'precio' => 1.80],
                ['nombre' => 'Esponjas x3', 'precio' => 2.00],
                ['nombre' => 'Jabón en polvo 800 g', 'precio' => 6.50],
            ],
        ],
        'congelados' => [
            'nombre' => 'Congelados', 'descripcion' => 'Productos congelados',
            'icono' => '❄️', 'clase' => 'congelados',
            'productos' => [
                ['nombre' => 'Hamburguesas x4', 'precio' => 8.50],
                ['nombre' => 'Papas congeladas 1 kg', 'precio' => 7.00],
                ['nombre' => 'Helado 1 L', 'precio' => 9.00],
                ['nombre' => 'Verduras mixtas 500 g', 'precio' => 4.50],
            ],
        ],
    ];

    // A cada producto se le agrega un id único ("snacks-1") y su categoría
    foreach ($categorias as $clave => $categoria) {
        foreach ($categoria['productos'] as $numero => $producto) {
            $categorias[$clave]['productos'][$numero]['id'] = $clave . '-' . ($numero + 1);
            $categorias[$clave]['productos'][$numero]['categoria'] = $clave;
        }
    }

    return $categorias;
}

/** Busca un producto por su id. Devuelve null si no existe. */
function obtener_producto(string $id): ?array
{
    foreach (obtener_categorias() as $categoria) {
        foreach ($categoria['productos'] as $producto) {
            if ($producto['id'] === $id) {
                return $producto;
            }
        }
    }

    return null;
}

/** Da formato al precio: 25 → "$25.00" */
function formato_precio(float $precio): string
{
    return '$' . number_format($precio, 2, '.', '');
}
