<?php
require_once __DIR__ . '/../models/MahasiswaModel.php';

class MahasiswaController
{
    public function index()
    {
        $model = new MahasiswaModel();
        $mahasiswa = $model->all();   // data dari database

        // View memakai variabel $mahasiswa
        require __DIR__ . '/../views/mahasiswa/index.php';
    }
}
