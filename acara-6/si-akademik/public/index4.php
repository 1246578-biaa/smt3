<?php
// File: public/index.php
// Entry point sementara (belum ada Controller/routing resmi)

require __DIR__ . '/../app/Models/mahasiswa.php';

use App\Models\mahasiswa;

// Beberapa object Mahasiswa (data sementara, belum dari database)
$daftarMahasiswa = [
    new Mahasiswa("E41251105", "Wahyu Oktavia", "Teknik Informatika"),
    new Mahasiswa("E41251109", "Miftakhul Jannah", "Sistem Informasi"),
    new Mahasiswa("E41667278", "Gladis Diva", "Manajemen Informatika"),
];

$title   = "Daftar Mahasiswa";
$content = __DIR__ . '/../app/Views/mahasiswa/index.php';

require __DIR__ . '/../app/Views/layouts/main.php';