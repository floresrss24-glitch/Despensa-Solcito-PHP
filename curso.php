<?php
$titulo_pagina = 'Curso';
$hojas_estilo = ['css/style.css', 'css/curso.css'];

require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/includes/nav.php';
?>
    <section class="curso-header">
        <h1>Curso de Administración de una Despensa</h1>
        <p>Aprende a gestionar correctamente un negocio de ventas minoristas.</p>
    </section>

    <section class="curso-container">

        <div class="tema">
            <h2>Tema 1: Introducción</h2>

            <h3>¿Qué es una despensa?</h3>

            <p>
                Una despensa es un comercio minorista dedicado a la venta
                de productos de consumo diario.
            </p>
        </div>

        <div class="tema">
            <h2>Tema 2: Organización de Productos</h2>

            <h3>Clasificación de Productos</h3>

            <p>
                Los productos pueden clasificarse en bebidas,
                alimentos, limpieza, congelados y golosinas.
            </p>

            <h3>Control de Stock</h3>

            <p>
                Permite conocer la cantidad de productos disponibles.
            </p>
        </div>

        <div class="tema">
            <h2>Tema 3: Atención al Cliente</h2>

            <h3>Importancia del Servicio</h3>

            <p>
                Una buena atención mejora la experiencia del cliente.
            </p>
        </div>

        <div class="tema">
            <h2>Tema 4: Promociones y Ventas</h2>

            <h3>Descuentos y Ofertas</h3>

            <p>
                Las promociones ayudan a aumentar las ventas y atraer clientes.
            </p>
        </div>

        <div class="tema">
            <h2>Tema 5: Horarios de Atención</h2>

            <pre>
Lunes a Viernes
08:00 - 22:00

Sábados
08:00 - 20:00
            </pre>

            <p>
                También podemos informar horarios especiales.<br>
                Consulte nuestras redes sociales para novedades.
            </p>
        </div>

    </section>

    <hr>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
