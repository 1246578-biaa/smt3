<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

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

use app\controllers\MahasiswaController;

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

$base = '/smt3/acara-3/si-akademik/public';
if (str_starts_with($uri, $base)) {
    $uri = substr($uri, strlen($base)) ?: '/';
}

$method = $_SERVER['REQUEST_METHOD'];

if (isset($routes[$method][$uri])) {
    [$controllerName, $action] = $routes[$method][$uri];
    $controllerClass = "app\\controllers\\{$controllerName}";
    $controller = new $controllerClass();
    $controller->$action();
    exit;
}

if ($method === 'GET' && preg_match('#^/mahasiswa/(\d+)$#', $uri, $matches)) {
    $id = $matches[1];
    $controller = new MahasiswaController();
    $controller->show($id);
    exit;
}

http_response_code(404);
echo "404 - Halaman tidak ditemukan";