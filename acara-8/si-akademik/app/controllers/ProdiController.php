<?php
require_once __DIR__ . '/../core/helpers.php';
require_once __DIR__ . '/../models/ProdiModel.php';

class ProdiController
{
    private ProdiModel $model;

    public function __construct()
    {
        $this->model = new ProdiModel();
    }

    public function index(): void
    {
        $prodi = $this->model->all();
        view('prodi/index', compact('prodi'));
    }

    public function create(): void
    {
        $old  = pull_old();
        $item = null;
        view('prodi/form', compact('old', 'item'));
    }

    public function store(): void
    {
        $data = $this->input();
        if ($error = $this->validate($data)) {
            flash('danger', $error);
            with_old($data);
            redirect('prodi.php?action=create');
        }
        try {
            $this->model->create($data);
            flash('success', 'Prodi berhasil ditambahkan.');
            redirect('prodi.php');
        } catch (PDOException $e) {
            flash('danger', db_error_message($e));
            with_old($data);
            redirect('prodi.php?action=create');
        }
    }

    public function show(): void
    {
        $id   = (int)($_GET['id'] ?? 0);
        $item = $this->model->find($id);
        if (!$item) {
            flash('danger', 'Prodi tidak ditemukan.');
            redirect('prodi.php');
        }
        $mahasiswa = $this->model->mahasiswa($id);   // relasi One-to-Many
        view('prodi/show', compact('item', 'mahasiswa'));
    }

    public function edit(): void
    {
        $item = $this->model->find((int)($_GET['id'] ?? 0));
        if (!$item) {
            flash('danger', 'Prodi tidak ditemukan.');
            redirect('prodi.php');
        }
        $old = pull_old();
        view('prodi/form', compact('old', 'item'));
    }

    public function update(): void
    {
        $id   = (int)($_POST['id'] ?? 0);
        $data = $this->input();
        if ($error = $this->validate($data)) {
            flash('danger', $error);
            with_old($data);
            redirect('prodi.php?action=edit&id=' . $id);
        }
        try {
            $this->model->update($id, $data);
            flash('success', 'Prodi berhasil diubah.');
            redirect('prodi.php');
        } catch (PDOException $e) {
            flash('danger', db_error_message($e));
            with_old($data);
            redirect('prodi.php?action=edit&id=' . $id);
        }
    }

    public function destroy(): void
    {
        try {
            $this->model->delete((int)($_POST['id'] ?? 0));
            flash('success', 'Prodi berhasil dihapus.');
        } catch (PDOException $e) {
            flash('danger', db_error_message($e));   // contoh: prodi masih dipakai mahasiswa
        }
        redirect('prodi.php');
    }

    private function input(): array
    {
        return [
            'kode' => trim($_POST['kode'] ?? ''),
            'nama' => trim($_POST['nama'] ?? ''),
        ];
    }

    private function validate(array $d): ?string
    {
        if ($d['kode'] === '' || $d['nama'] === '') {
            return 'Kode dan nama prodi wajib diisi.';
        }
        return null;
    }
}
