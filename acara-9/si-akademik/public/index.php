<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();  

define('BASE_URL', '/smt3/acara-6/si-akademik/public');

require_once __DIR__ . '/../config/app.php';
require_once __DIR__ . '/../routes/web.php';

spl_autoload_register(function ($class) {
    $class = ltrim($class, '\\');
    if (stripos($class, 'app\\') !== 0) return;

    $parts = explode('\\', substr($class, 4));
    $name  = array_pop($parts);
    $dir   = strtolower(implode('/', $parts));

    $file = __DIR__ . "/../app/$dir/$name.php";
    if (file_exists($file)) require $file;
});

function dispatch(array $route, array $params = []): void
{
    [$controllerName, $action, $middleware] = $route;

    foreach ($middleware as $mw) {
        $mwInstance = new $mw();
        $mwInstance->handle();
    }

    $class = "app\\controllers\\{$controllerName}";
    $controller = new $class();
    $controller->$action(...$params);
}

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
if (str_starts_with($uri, BASE_URL)) {
    $uri = substr($uri, strlen(BASE_URL)) ?: '/';
}

$method = $_SERVER['REQUEST_METHOD'];

if (isset($routes[$method][$uri])) {
    dispatch($routes[$method][$uri]);
    exit;
}

if ($method === 'GET' && preg_match('#^/mahasiswa/(\d+)$#', $uri, $m)) {
    dispatch(['MahasiswaController', 'show', [\app\core\middleware\AuthMiddleware::class]], [$m[1]]);
    exit;
}

http_response_code(404);
echo "404 - Halaman tidak ditemukan";