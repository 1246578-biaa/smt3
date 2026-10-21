<?php
require_once __DIR__ . '/helpers.php';

// Memanggil method controller berdasarkan ?action=... (index, create, store, edit, update, destroy)
function dispatch(object $controller): void
{
    session_start();

    $action  = $_GET['action'] ?? 'index';
    $allowed = ['index', 'create', 'store', 'show', 'edit', 'update', 'destroy'];
    $postOnly = ['store', 'update', 'destroy'];   // operasi yang mengubah data wajib POST

    if (!in_array($action, $allowed, true)) {
        http_response_code(404);
        exit('Halaman tidak ditemukan');
    }
    if (in_array($action, $postOnly, true) && $_SERVER['REQUEST_METHOD'] !== 'POST') {
        http_response_code(405);
        exit('Operasi ini hanya boleh lewat POST');
    }

    $controller->$action();
}
