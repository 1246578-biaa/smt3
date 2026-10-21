<?php
// Pintu masuk CRUD Mahasiswa. Buka: http://localhost:8000/mahasiswa.php
require_once __DIR__ . '/../app/core/dispatcher.php';
require_once __DIR__ . '/../app/controllers/MahasiswaController.php';

dispatch(new MahasiswaController());
