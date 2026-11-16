<?php
/**
 * config/env.php
 * Lee el archivo .env de la raíz del proyecto y deja disponibles
 * las variables de configuración para todas las páginas.
 */

// Carpeta raíz del proyecto (un nivel arriba de /config)
define('RAIZ_PROYECTO', dirname(__DIR__));

/**
 * Lee un archivo .env y devuelve un arreglo clave => valor.
 * Ignora líneas vacías y comentarios (los que empiezan con #).
 */
function cargar_env(string $archivo): array
{
    $variables = [];

    if (!is_readable($archivo)) {
        return $variables;
    }

    $lineas = file($archivo, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

    foreach ($lineas as $linea) {
        $linea = trim($linea);

        if ($linea === '' || $linea[0] === '#' || strpos($linea, '=') === false) {
            continue;
        }

        [$clave, $valor] = explode('=', $linea, 2);
        $clave = trim($clave);
        $valor = trim($valor);

        // Quita las comillas que rodean al valor: "Hola" o 'Hola'
        $comilla = $valor !== '' ? $valor[0] : '';
        if (($comilla === '"' || $comilla === "'") && substr($valor, -1) === $comilla && strlen($valor) >= 2) {
            $valor = substr($valor, 1, -1);
        }

        $variables[$clave] = $valor;
    }

    return $variables;
}

/**
 * Devuelve el valor de una variable del .env.
 * Si no existe, devuelve el valor por defecto.
 */
function env(string $clave, mixed $defecto = null): mixed
{
    static $variables = null;

    if ($variables === null) {
        $variables = cargar_env(RAIZ_PROYECTO . '/.env');
    }

    return $variables[$clave] ?? $defecto;
}

/**
 * Escapa un texto antes de mostrarlo en HTML (evita inyección de código).
 */
function e(mixed $texto): string
{
    return htmlspecialchars((string) $texto, ENT_QUOTES, 'UTF-8');
}

// Constantes globales leídas desde el .env
define('APP_NAME', env('APP_NAME', 'Despensa Solcito'));
define('APP_EMAIL', env('APP_EMAIL', 'contacto@despensasolcito.com'));
define('APP_ENV', env('APP_ENV', 'local'));

// En local se muestran los errores de PHP; en producción se ocultan
if (APP_ENV === 'local') {
    ini_set('display_errors', '1');
    error_reporting(E_ALL);
} else {
    ini_set('display_errors', '0');
}
