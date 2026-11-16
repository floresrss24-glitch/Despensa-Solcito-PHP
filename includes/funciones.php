<?php
/**
 * includes/funciones.php
 * Funciones comunes: sesión, mensajes flash, protección CSRF,
 * lectura de formularios y almacenamiento en archivos.
 */
require_once __DIR__ . '/../config/env.php';

// Carpeta donde se guardan los datos generados (usuarios, mensajes, pedidos)
define('RUTA_STORAGE', RAIZ_PROYECTO . '/storage');

// Inicia la sesión una sola vez. Debe ocurrir antes de enviar cualquier HTML.
if (session_status() === PHP_SESSION_NONE) {
    session_set_cookie_params([
        'lifetime' => 0,
        'path'     => '/',
        'httponly' => true,
        'samesite' => 'Lax',
    ]);
    session_start();
}

/* ---------- Redirecciones y mensajes ---------- */

/** Redirige a otra página y detiene la ejecución. */
function redirigir(string $destino): void
{
    header('Location: ' . $destino);
    exit;
}

/** Guarda un mensaje que se mostrará en la próxima página (tipo: exito, error, info). */
function flash(string $tipo, string $mensaje): void
{
    $_SESSION['flash'][] = ['tipo' => $tipo, 'mensaje' => $mensaje];
}

/** Devuelve los mensajes guardados y los borra. */
function flash_leer(): array
{
    $mensajes = $_SESSION['flash'] ?? [];
    unset($_SESSION['flash']);

    return $mensajes;
}

/* ---------- Protección CSRF ---------- */

/** Token secreto de la sesión actual. */
function csrf_token(): string
{
    if (empty($_SESSION['csrf'])) {
        $_SESSION['csrf'] = bin2hex(random_bytes(32));
    }

    return $_SESSION['csrf'];
}

/** Campo oculto que va dentro de cada formulario POST. */
function csrf_campo(): string
{
    return '<input type="hidden" name="csrf" value="' . e(csrf_token()) . '">';
}

/** Comprueba que el formulario enviado trae el token correcto. */
function csrf_valido(): bool
{
    $enviado = $_POST['csrf'] ?? '';

    return is_string($enviado) && hash_equals(csrf_token(), $enviado);
}

/* ---------- Lectura de formularios ---------- */

/** true si la petición es un envío de formulario (POST). */
function es_post(): bool
{
    return ($_SERVER['REQUEST_METHOD'] ?? 'GET') === 'POST';
}

/** Lee un campo POST como texto, sin espacios en los extremos. */
function post(string $campo, string $defecto = ''): string
{
    $valor = $_POST[$campo] ?? $defecto;

    return is_string($valor) ? trim($valor) : $defecto;
}

/** Lee un campo POST sin modificarlo (para contraseñas). */
function post_crudo(string $campo): string
{
    $valor = $_POST[$campo] ?? '';

    return is_string($valor) ? $valor : '';
}

/** Valor escapado de un campo POST, para volver a llenar el formulario si hubo errores. */
function old(string $campo): string
{
    return e(post($campo));
}

/* ---------- Validaciones ---------- */

/** Cantidad de caracteres de un texto (cuenta bien las tildes). */
function largo(string $texto): int
{
    return function_exists('mb_strlen') ? mb_strlen($texto) : strlen($texto);
}

/** true si el texto es un correo electrónico válido. */
function correo_valido(string $correo): bool
{
    return strlen($correo) <= 120 && filter_var($correo, FILTER_VALIDATE_EMAIL) !== false;
}

/* ---------- Almacenamiento en archivos (reemplaza a una base de datos) ---------- */

/** Ruta completa de un archivo dentro de /storage (crea la carpeta si falta). */
function storage_ruta(string $archivo): string
{
    if (!is_dir(RUTA_STORAGE)) {
        mkdir(RUTA_STORAGE, 0775, true);
    }

    return RUTA_STORAGE . '/' . $archivo;
}

/** Agrega un registro (una línea JSON) al final de un archivo de registro. */
function storage_agregar_linea(string $archivo, array $registro): bool
{
    $linea = json_encode($registro, JSON_UNESCAPED_UNICODE) . PHP_EOL;

    return file_put_contents(storage_ruta($archivo), $linea, FILE_APPEND | LOCK_EX) !== false;
}

/** Lee un archivo JSON y lo devuelve como arreglo (vacío si no existe). */
function storage_leer_json(string $archivo): array
{
    $ruta = storage_ruta($archivo);

    if (!is_file($ruta)) {
        return [];
    }

    $datos = json_decode((string) file_get_contents($ruta), true);

    return is_array($datos) ? $datos : [];
}

/** Guarda un arreglo como archivo JSON. */
function storage_guardar_json(string $archivo, array $datos): bool
{
    $json = json_encode($datos, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);

    return file_put_contents(storage_ruta($archivo), $json, LOCK_EX) !== false;
}

/**
 * Valida y guarda un comprobante de pago (JPG, PNG o PDF de hasta 2 MB).
 * Devuelve ['ok' => bool, 'nombre' => string, 'error' => string].
 */
function guardar_comprobante(array $archivo): array
{
    $fallo = static function (string $mensaje): array {
        return ['ok' => false, 'nombre' => '', 'error' => $mensaje];
    };

    if (($archivo['error'] ?? UPLOAD_ERR_NO_FILE) !== UPLOAD_ERR_OK) {
        return $fallo('No se pudo subir el comprobante. Intentá de nuevo.');
    }

    if (($archivo['size'] ?? 0) > 2 * 1024 * 1024) {
        return $fallo('El comprobante no puede superar los 2 MB.');
    }

    // Se comprueba el contenido real del archivo, no solo su extensión
    $permitidos = ['image/jpeg' => 'jpg', 'image/png' => 'png', 'application/pdf' => 'pdf'];
    $tipo = (new finfo(FILEINFO_MIME_TYPE))->file($archivo['tmp_name']);

    if (!isset($permitidos[$tipo])) {
        return $fallo('El comprobante debe ser un archivo JPG, PNG o PDF.');
    }

    $carpeta = storage_ruta('comprobantes');
    if (!is_dir($carpeta)) {
        mkdir($carpeta, 0775, true);
    }

    // Nombre aleatorio: nunca se usa el nombre que eligió el usuario
    $nombre = bin2hex(random_bytes(8)) . '.' . $permitidos[$tipo];

    if (!move_uploaded_file($archivo['tmp_name'], $carpeta . '/' . $nombre)) {
        return $fallo('No se pudo guardar el comprobante.');
    }

    return ['ok' => true, 'nombre' => $nombre, 'error' => ''];
}
