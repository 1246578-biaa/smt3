<?php
require_once __DIR__ . '/../core/BaseController.php';
require_once __DIR__ . '/../models/ProdiModel.php';

class ProdiController extends BaseController
{
    private ProdiModel $model;

    public function __construct()
    {
        $this->model = new ProdiModel();
    }

    public function index(): void
    {
        $prodi = $this->model->all();
        $this->view('prodi/index', compact('prodi'));
    }

    public function create(): void
    {
        $old  = $this->pullOld();
        $item = null;
        $this->view('prodi/form', compact('old', 'item'));
    }

    public function store(): void
    {
        $data = $this->input();
        if ($error = $this->validate($data)) {
            $this->flash('danger', $error);
            $this->withOld($data);
            $this->redirect('prodi.php?action=create');
        }
        try {
            $this->model->create($data);
            $this->flash('success', 'Prodi berhasil ditambahkan.');
            $this->redirect('prodi.php');
        } catch (PDOException $e) {
            $this->flash('danger', db_error_message($e));
            $this->withOld($data);
            $this->redirect('prodi.php?action=create');
        }
    }

    public function show(): void
    {
        $id   = (int)($_GET['id'] ?? 0);
        $item = $this->model->find($id);
        if (!$item) {
            $this->flash('danger', 'Prodi tidak ditemukan.');
            $this->redirect('prodi.php');
        }
        $mahasiswa = $this->model->mahasiswa($id);   // relasi One-to-Many
        $this->view('prodi/show', compact('item', 'mahasiswa'));
    }

    public function edit(): void
    {
        $item = $this->model->find((int)($_GET['id'] ?? 0));
        if (!$item) {
            $this->flash('danger', 'Prodi tidak ditemukan.');
            $this->redirect('prodi.php');
        }
        $old = $this->pullOld();
        $this->view('prodi/form', compact('old', 'item'));
    }

    public function update(): void
    {
        $id   = (int)($_POST['id'] ?? 0);
        $data = $this->input();
        if ($error = $this->validate($data)) {
            $this->flash('danger', $error);
            $this->withOld($data);
            $this->redirect('prodi.php?action=edit&id=' . $id);
        }
        try {
            $this->model->update($id, $data);
            $this->flash('success', 'Prodi berhasil diubah.');
            $this->redirect('prodi.php');
        } catch (PDOException $e) {
            $this->flash('danger', db_error_message($e));
            $this->withOld($data);
            $this->redirect('prodi.php?action=edit&id=' . $id);
        }
    }

    public function destroy(): void
    {
        try {
            $this->model->delete((int)($_POST['id'] ?? 0));
            $this->flash('success', 'Prodi berhasil dihapus.');
        } catch (PDOException $e) {
            $this->flash('danger', db_error_message($e));   // contoh: prodi masih dipakai mahasiswa
        }
        $this->redirect('prodi.php');
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