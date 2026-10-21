<?php
namespace app\controllers;

class HomeController
{
    public function index()
    {
        echo "Halaman Beranda";
    }

    public function dashboard()
    {
        $flash = $_SESSION['flash'] ?? null;
        unset($_SESSION['flash']);
        ?>
        <!DOCTYPE html>
        <html lang="id">
        <head>
            <meta charset="UTF-8">
            <title>Dashboard</title>
            <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
        </head>
        <body>
        <div class="container mt-4">
            <?php if ($flash): ?>
                <div class="alert alert-<?= $flash['type'] ?>"><?= htmlspecialchars($flash['message']) ?></div>
            <?php endif; ?>
            <h3>Dashboard</h3>
            <p>Halo, <?= htmlspecialchars($_SESSION['user_name']) ?></p>
            <a href="<?= BASE_URL ?>/mahasiswa" class="btn btn-primary">Data Mahasiswa</a>
            <a href="<?= BASE_URL ?>/logout" class="btn btn-outline-danger">Logout</a>
        </div>
        </body>
        </html>
        <?php
    }
}