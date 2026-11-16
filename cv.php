<?php
$titulo_pagina = 'Mi CV';
$hojas_estilo = ['css/style.css', 'css/cv.css'];

require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/includes/nav.php';
?>
    <section class="cv-container">

        <div class="cv-header">
            <img src="img/foto-perfil.jpg" alt="Foto de perfil">

            <h1>Ricardo Apellido</h1>

            <p>Estudiante de Programación Web</p>
        </div>

        <div class="cv-section">
            <h2>Perfil Profesional</h2>
            <p>
                Estudiante con interés en desarrollo web, redes informáticas
                y diseño de sitios modernos. Responsable, comprometido y con
                ganas de seguir aprendiendo nuevas tecnologías.
            </p>
        </div>

        <div class="cv-section">
            <h2>Datos Personales</h2>

            <ul>
                <li><strong>Edad:</strong> 16 años</li>
                <li><strong>Ciudad:</strong> Salta, Argentina</li>
                <li><strong>Email:</strong> correo@ejemplo.com</li>
                <li><strong>Teléfono:</strong> +54 387 1234567</li>
            </ul>
        </div>

        <div class="cv-section">
            <h2>Educación</h2>

            <div class="timeline">
                <h3>Técnico en Informática</h3>
                <span>2023 - Actualidad</span>
                <p>Escuela Técnica.</p>
            </div>
        </div>

        <div class="cv-section">
            <h2>Habilidades</h2>

            <div class="skills">
                <span>HTML</span>
                <span>CSS</span>
                <span>JavaScript</span>
                <span>Redes</span>
                <span>Word</span>
                <span>Excel</span>
            </div>
        </div>

        <div class="cv-section">
            <h2>Idiomas</h2>

            <ul>
                <li>Español — Nativo</li>
                <li>Inglés — Básico</li>
            </ul>
        </div>

    </section>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
