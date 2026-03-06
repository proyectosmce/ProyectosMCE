<?php
// Configuración básica de la base de datos
// Ajusta las variables de entorno DB_HOST, DB_USER, DB_PASS y DB_NAME si necesitas credenciales distintas.
$DB_HOST   = getenv('DB_HOST') ?: 'localhost';          // Servidor local
$DB_USER   = getenv('DB_USER') ?: 'root';               // Usuario por defecto en XAMPP
$DB_PASS   = getenv('DB_PASS') ?: '';                   // Clave vacía por defecto
$DB_NAME   = getenv('DB_NAME') ?: 'proyectosmce';       // Nombre de la BD local
$DB_PORT   = getenv('DB_PORT') ?: 3306;                 // Puerto MySQL por defecto
$DB_SOCKET = getenv('DB_SOCKET') ?: null; // Úsalo si tu hosting exige conectar por socket

// Si usas localhost, fuerzo 127.0.0.1 para evitar que intente un socket inexistente (HY000 [2002])
if ($DB_HOST === 'localhost') {
    $DB_HOST = '127.0.0.1';
}

// Evita excepciones de mysqli y controla el error manualmente
mysqli_report(MYSQLI_REPORT_OFF);

// Crear conexión mysqli (forzando puerto TCP o socket si se indica)
$conn = new mysqli($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME, (int) $DB_PORT, $DB_SOCKET);

// Verificar conexión
if ($conn->connect_error) {
    $hint = '';
    if ($conn->connect_errno === 2002) {
        $hint = 'Revisa DB_HOST/DB_PORT y que el servidor MySQL acepte conexiones (en hosting gratuito suele requerir ejecutar el código en el propio servidor).';
    }
    error_log('Error de conexión a la base de datos: ' . $conn->connect_error . ' ' . $hint);
    http_response_code(500);
    exit('Error de conexión a la base de datos. ' . $hint);
}

// Establecer charset
if (!$conn->set_charset('utf8mb4')) {
    error_log('No se pudo establecer el charset utf8mb4: ' . $conn->error);
}

// Iniciar sesión (para secciones admin)
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Limpia entradas básicas antes de usarlas
function sanitize($data)
{
    return htmlspecialchars(strip_tags(trim($data)), ENT_QUOTES, 'UTF-8');
}

// Redirección sencilla
function redirect($url)
{
    header("Location: $url");
    exit;
}

function app_base_path()
{
    static $basePath = null;

    if ($basePath !== null) {
        return $basePath;
    }

    $envBase = getenv('APP_BASE_PATH');
    if ($envBase !== false && $envBase !== '') {
        $normalizedEnvBase = '/' . trim(str_replace('\\', '/', $envBase), '/');
        $basePath = $normalizedEnvBase === '/' ? '' : $normalizedEnvBase;
        return $basePath;
    }

    $projectRoot = realpath(dirname(__DIR__));
    $documentRoot = isset($_SERVER['DOCUMENT_ROOT']) ? realpath($_SERVER['DOCUMENT_ROOT']) : false;

    if ($projectRoot && $documentRoot) {
        $normalizedProjectRoot = str_replace('\\', '/', $projectRoot);
        $normalizedDocumentRoot = rtrim(str_replace('\\', '/', $documentRoot), '/');

        if (strpos($normalizedProjectRoot, $normalizedDocumentRoot) === 0) {
            $relativePath = trim(substr($normalizedProjectRoot, strlen($normalizedDocumentRoot)), '/');
            $basePath = $relativePath === '' ? '' : '/' . $relativePath;
            return $basePath;
        }
    }

    $basePath = '';
    return $basePath;
}

function app_url($path = '')
{
    $path = ltrim((string) $path, '/');
    $basePath = app_base_path();

    if ($path === '') {
        return $basePath !== '' ? $basePath . '/' : '/';
    }

    return ($basePath !== '' ? $basePath : '') . '/' . $path;
}

function app_absolute_url($path = '')
{
    $scheme = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
    $host = $_SERVER['HTTP_HOST'] ?? 'localhost';

    return $scheme . '://' . $host . app_url($path);
}

function current_absolute_url()
{
    $scheme = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
    $host = $_SERVER['HTTP_HOST'] ?? 'localhost';
    $requestUri = $_SERVER['REQUEST_URI'] ?? '/';

    return $scheme . '://' . $host . $requestUri;
}
?>
