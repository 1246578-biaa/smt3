<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SI Akademik</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-expand navbar-dark bg-dark">
    <div class="container">
        <span class="navbar-brand">SI Akademik</span>
        <div class="navbar-nav">
            <a class="nav-link" href="mahasiswa.php">Mahasiswa</a>
            <a class="nav-link" href="prodi.php">Prodi</a>
            <a class="nav-link" href="matakuliah.php">Mata Kuliah</a>
        </div>
    </div>
</nav>
<main class="container mt-4">
<?php if (!empty($_SESSION['flash'])): $f = $_SESSION['flash']; unset($_SESSION['flash']); ?>
    <div class="alert alert-<?= e($f['type']) ?>"><?= e($f['msg']) ?></div>
<?php endif; ?>
