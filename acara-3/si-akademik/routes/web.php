<?php
// File: routes/web.php

$routes = [
    'GET' => [
        '/'                  => ['HomeController', 'index'],
        '/mahasiswa'         => ['MahasiswaController', 'index'],
        '/mahasiswa/create'  => ['MahasiswaController', 'create'],
        '/mahasiswa/{id}'    => ['MahasiswaController', 'show'], //tugas mandiri
        '/login'             => ['AuthController', 'loginForm'],
    ],
    'POST' => [
        '/mahasiswa'         => ['MahasiswaController', 'store'],
        '/login'             => ['AuthController', 'login'],
    ],
];