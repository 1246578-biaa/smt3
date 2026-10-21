<?php
require_once __DIR__ . '/../core/BaseController.php';
require_once __DIR__ . '/../models/MatakuliahModel.php';
require_once __DIR__ . '/../models/ProdiModel.php';

class MatakuliahController extends BaseController
{
    private MatakuliahModel $model;

    public function __construct()
    {
        $this->model = new MatakuliahModel();
    }

    public function index(): void
    {
        $matakuliah = $this->model->all();
        $this->view('matakuliah/index', compact('matakuliah'));
    }

    public function create(): void
    {
        $prodi = (new ProdiModel())->all();
        $old   = $this->pullOld();
        $item  = null;
        $this->view('matakuliah/form', compact('prodi', 'old', 'item'));
    }

    public function store(): void
    {
        $data = $this->input();
        if ($error = $this->validate($data)) {
            $this->flash('danger', $error);
            $this->withOld($data);
            $this->redirect('matakuliah.php?action=create');
        }
        try {
            $this->model->create($data);
            $this->flash('success', 'Mata kuliah berhasil ditambahkan.');
            $this->redirect('matakuliah.php');
        } catch (PDOException $e) {
            $this->flash('danger', db_error_message($e));
            $this->withOld($data);
            $this->redirect('matakuliah.php?action=create');
        }
    }

    public function show(): void
    {
        $item = $this->model->findWithProdi((int)($_GET['id'] ?? 0));
        if (!$item) {
            $this->flash('danger', 'Mata kuliah tidak ditemukan.');
            $this->redirect('matakuliah.php');
        }
        $this->view('matakuliah/show', compact('item'));
    }

    public function edit(): void
    {
        $item = $this->model->find((int)($_GET['id'] ?? 0));
        if (!$item) {
            $this->flash('danger', 'Mata kuliah tidak ditemukan.');
            $this->redirect('matakuliah.php');
        }
        $prodi = (new ProdiModel())->all();
        $old   = $this->pullOld();
        $this->view('matakuliah/form', compact('prodi', 'old', 'item'));
    }

    public function update(): void
    {
        $id   = (int)($_POST['id'] ?? 0);
        $data = $this->input();
        if ($error = $this->validate($data)) {
            $this->flash('danger', $error);
            $this->withOld($data);
            $this->redirect('matakuliah.php?action=edit&id=' . $id);
        }
        try {
            $this->model->update($id, $data);
            $this->flash('success', 'Mata kuliah berhasil diubah.');
            $this->redirect('matakuliah.php');
        } catch (PDOException $e) {
            $this->flash('danger', db_error_message($e));
            $this->withOld($data);
            $this->redirect('matakuliah.php?action=edit&id=' . $id);
        }
    }

    public function destroy(): void
    {
        try {
            $this->model->delete((int)($_POST['id'] ?? 0));
            $this->flash('success', 'Mata kuliah berhasil dihapus.');
        } catch (PDOException $e) {
            $this->flash('danger', db_error_message($e));
        }
        $this->redirect('matakuliah.php');
    }

    private function input(): array
    {
        return [
            'kode'     => trim($_POST['kode'] ?? ''),
            'nama'     => trim($_POST['nama'] ?? ''),
            'sks'      => (int)($_POST['sks'] ?? 0),
            'prodi_id' => (int)($_POST['prodi_id'] ?? 0),
        ];
    }

    private function validate(array $d): ?string
    {
        if ($d['kode'] === '' || $d['nama'] === '') {
            return 'Kode dan nama mata kuliah wajib diisi.';
        }
        if ($d['sks'] < 1 || $d['sks'] > 6) {
            return 'SKS harus antara 1 sampai 6.';
        }
        if ($d['prodi_id'] <= 0) {
            return 'Prodi wajib dipilih.';
        }
        return null;
    }
}