<?php
// Pintu masuk CRUD Matakuliah. Buka: http://localhost:8000/matakuliah.php
require_once __DIR__ . '/../app/core/dispatcher.php';
require_once __DIR__ . '/../app/controllers/MatakuliahController.php';

dispatch(new MatakuliahController());
