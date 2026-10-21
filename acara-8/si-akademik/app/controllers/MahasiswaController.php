<?php
require_once __DIR__ . '/../core/helpers.php';
require_once __DIR__ . '/../models/MahasiswaModel.php';
require_once __DIR__ . '/../models/ProdiModel.php';

class MahasiswaController
{
    private MahasiswaModel $model;

    public function __construct()
    {
        $this->model = new MahasiswaModel();
    }

    // index: daftar data (+ pencarian)
    public function index(): void
    {
        $search    = trim($_GET['q'] ?? '');
        $mahasiswa = $this->model->all($search);
        view('mahasiswa/index', compact('mahasiswa', 'search'));
    }

    // create: form tambah
    public function create(): void
    {
        $prodi = (new ProdiModel())->all();
        $old   = pull_old();
        $item  = null;
        view('mahasiswa/form', compact('prodi', 'old', 'item'));
    }

    // store: proses simpan (POST)
    public function store(): void
    {
        $data = $this->input();
        if ($error = $this->validate($data)) {
            flash('danger', $error);
            with_old($data);
            redirect('mahasiswa.php?action=create');
        }
        try {
            $this->model->create($data);
            flash('success', 'Data mahasiswa berhasil ditambahkan.');
            redirect('mahasiswa.php');
        } catch (PDOException $e) {
            flash('danger', db_error_message($e));
            with_old($data);
            redirect('mahasiswa.php?action=create');
        }
    }

    // show: detail satu data
    public function show(): void
    {
        $item = $this->model->findWithProdi((int)($_GET['id'] ?? 0));
        if (!$item) {
            flash('danger', 'Data mahasiswa tidak ditemukan.');
            redirect('mahasiswa.php');
        }
        view('mahasiswa/show', compact('item'));
    }

    // edit: form edit
    public function edit(): void
    {
        $id   = (int)($_GET['id'] ?? 0);
        $item = $this->model->find($id);
        if (!$item) {
            flash('danger', 'Data mahasiswa tidak ditemukan.');
            redirect('mahasiswa.php');
        }
        $prodi = (new ProdiModel())->all();
        $old   = pull_old();
        view('mahasiswa/form', compact('prodi', 'old', 'item'));
    }

    // update: proses ubah (POST)
    public function update(): void
    {
        $id   = (int)($_POST['id'] ?? 0);
        $data = $this->input();
        if ($error = $this->validate($data)) {
            flash('danger', $error);
            with_old($data);
            redirect('mahasiswa.php?action=edit&id=' . $id);
        }
        try {
            $this->model->update($id, $data);
            flash('success', 'Data mahasiswa berhasil diubah.');
            redirect('mahasiswa.php');
        } catch (PDOException $e) {
            flash('danger', db_error_message($e));
            with_old($data);
            redirect('mahasiswa.php?action=edit&id=' . $id);
        }
    }

    // destroy: proses hapus (POST)
    public function destroy(): void
    {
        $id = (int)($_POST['id'] ?? 0);
        try {
            $this->model->delete($id);
            flash('success', 'Data mahasiswa berhasil dihapus.');
        } catch (PDOException $e) {
            flash('danger', db_error_message($e));
        }
        redirect('mahasiswa.php');
    }

    private function input(): array
    {
        return [
            'nim'      => trim($_POST['nim'] ?? ''),
            'nama'     => trim($_POST['nama'] ?? ''),
            'email'    => trim($_POST['email'] ?? ''),
            'prodi_id' => (int)($_POST['prodi_id'] ?? 0),
            'angkatan' => (int)($_POST['angkatan'] ?? date('Y')),
        ];
    }

    // Validasi sederhana: kembalikan pesan error, atau null jika valid
    private function validate(array $d): ?string
    {
        if ($d['nim'] === '' || $d['nama'] === '') {
            return 'NIM dan nama wajib diisi.';
        }
        if (!filter_var($d['email'], FILTER_VALIDATE_EMAIL)) {
            return 'Format email tidak valid.';
        }
        if ($d['prodi_id'] <= 0) {
            return 'Prodi wajib dipilih.';
        }
        if ($d['angkatan'] < 1990 || $d['angkatan'] > (int)date('Y') + 1) {
            return 'Angkatan tidak valid.';
        }
        return null;
    }
}
