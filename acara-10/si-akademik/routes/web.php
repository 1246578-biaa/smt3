<?php
use app\core\middleware\AuthMiddleware;

$auth = [AuthMiddleware::class];

$routes = [
    'GET' => [
        '/'                 => ['HomeController', 'index', []],
        '/login'            => ['AuthController', 'loginForm', []],
        '/logout'           => ['AuthController', 'logout', []],
        '/dashboard'        => ['HomeController', 'dashboard', $auth],
        '/mahasiswa'        => ['MahasiswaController', 'index', $auth],
        '/mahasiswa/create' => ['MahasiswaController', 'create', $auth],
    ],
    'POST' => [
        '/login'     => ['AuthController', 'login', []],
        '/mahasiswa' => ['MahasiswaController', 'store', $auth],
    ],
];