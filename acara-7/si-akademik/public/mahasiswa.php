<?php
// Jalan pintas Acara 7: memanggil Controller langsung (tanpa router/login).
// Buka: http://localhost:8000/mahasiswa.php
require_once __DIR__ . '/../app/controllers/MahasiswaController.php';

(new MahasiswaController())->index();
