<?php
/**
 * includes/auth.php
 * Registro, inicio de sesión y favoritos de los usuarios.
 * Los usuarios se guardan en storage/usuarios.json con la contraseña cifrada.
 */
require_once __DIR__ . '/funciones.php';

const ARCHIVO_USUARIOS = 'usuarios.json';

/** Todos los usuarios, indexados por correo en minúsculas. */
function usuarios_todos(): array
{
    return storage_leer_json(ARCHIVO_USUARIOS);
}

/** Busca un usuario por su correo. */
function usuario_por_correo(string $correo): ?array
{
    $usuarios = usuarios_todos();

    return $usuarios[strtolower($correo)] ?? null;
}

/** Crea una cuenta nueva. Devuelve el usuario, o null si no se pudo guardar. */
function registrar_usuario(string $nombre, string $correo, string $contrasena): ?array
{
    $usuarios = usuarios_todos();
    $clave = strtolower($correo);

    if (isset($usuarios[$clave])) {
        return null;
    }

    $usuario = [
        'nombre'    => $nombre,
        'correo'    => $clave,
        'hash'      => password_hash($contrasena, PASSWORD_DEFAULT),
        'creado'    => date('Y-m-d H:i:s'),
        'favoritos' => [],
    ];

    $usuarios[$clave] = $usuario;

    return storage_guardar_json(ARCHIVO_USUARIOS, $usuarios) ? $usuario : null;
}

/** Comprueba correo y contraseña. Devuelve el usuario o null. */
function verificar_credenciales(string $correo, string $contrasena): ?array
{
    $usuario = usuario_por_correo($correo);

    if ($usuario === null || !password_verify($contrasena, $usuario['hash'])) {
        return null;
    }

    return $usuario;
}

/** Guarda al usuario en la sesión (con un identificador de sesión nuevo). */
function iniciar_sesion(array $usuario): void
{
    session_regenerate_id(true);
    $_SESSION['usuario'] = [
        'nombre' => $usuario['nombre'],
        'correo' => $usuario['correo'],
    ];
}

/** Cierra la sesión del usuario. */
function cerrar_sesion(): void
{
    unset($_SESSION['usuario']);
    session_regenerate_id(true);
}

/** Usuario con sesión iniciada, o null si es un visitante. */
function usuario_actual(): ?array
{
    return $_SESSION['usuario'] ?? null;
}

/** Si no hay sesión iniciada, manda al login con un aviso. */
function requerir_login(string $mensaje = 'Iniciá sesión para continuar.'): void
{
    if (usuario_actual() === null) {
        flash('error', $mensaje);
        redirigir('login.php');
    }
}

/** Cambia el nombre de un usuario. */
function actualizar_nombre(string $correo, string $nombre): bool
{
    $usuarios = usuarios_todos();
    $clave = strtolower($correo);

    if (!isset($usuarios[$clave])) {
        return false;
    }

    $usuarios[$clave]['nombre'] = $nombre;

    if (!storage_guardar_json(ARCHIVO_USUARIOS, $usuarios)) {
        return false;
    }

    $_SESSION['usuario']['nombre'] = $nombre;

    return true;
}

/* ---------- Favoritos ---------- */

/** Ids de los productos favoritos de un usuario. */
function favoritos_de(string $correo): array
{
    $usuario = usuario_por_correo($correo);

    return $usuario['favoritos'] ?? [];
}

/** Agrega o quita un favorito. Devuelve true si quedó como favorito. */
function alternar_favorito(string $correo, string $idProducto): bool
{
    $usuarios = usuarios_todos();
    $clave = strtolower($correo);

    if (!isset($usuarios[$clave])) {
        return false;
    }

    $favoritos = $usuarios[$clave]['favoritos'] ?? [];
    $posicion = array_search($idProducto, $favoritos, true);

    if ($posicion === false) {
        $favoritos[] = $idProducto;
        $esFavorito = true;
    } else {
        unset($favoritos[$posicion]);
        $esFavorito = false;
    }

    $usuarios[$clave]['favoritos'] = array_values($favoritos);
    storage_guardar_json(ARCHIVO_USUARIOS, $usuarios);

    return $esFavorito;
}

/** Quita un producto de los favoritos (nunca lo agrega). */
function quitar_favorito(string $correo, string $idProducto): void
{
    if (in_array($idProducto, favoritos_de($correo), true)) {
        alternar_favorito($correo, $idProducto);
    }
}
