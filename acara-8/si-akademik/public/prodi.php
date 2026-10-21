<?php
// Pintu masuk CRUD Prodi. Buka: http://localhost:8000/prodi.php
require_once __DIR__ . '/../app/core/dispatcher.php';
require_once __DIR__ . '/../app/controllers/ProdiController.php';

dispatch(new ProdiController());
