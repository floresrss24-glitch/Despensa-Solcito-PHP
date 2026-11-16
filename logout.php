<?php
require_once __DIR__ . '/includes/auth.php';

cerrar_sesion();
flash('exito', 'Cerraste sesión correctamente.');
redirigir('index.php');
