<?php
// Composition root: di sini objek-objek dirakit dan disuntikkan.
// Database -> Repository -> Controller
require_once __DIR__ . '/../app/core/dispatcher.php';
require_once __DIR__ . '/../app/core/database.php';
require_once __DIR__ . '/../app/repositories/MahasiswaRepository.php';
require_once __DIR__ . '/../app/models/ProdiModel.php';
require_once __DIR__ . '/../app/controllers/MahasiswaController.php';

$repo = new MahasiswaRepository(Database::getInstance());   // Repository memiliki koneksi PDO
$controller = new MahasiswaController($repo, new ProdiModel()); // Controller memiliki Repository

dispatch($controller);
