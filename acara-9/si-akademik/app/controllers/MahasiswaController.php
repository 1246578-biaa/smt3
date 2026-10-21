<?php
require_once __DIR__ . '/../core/helpers.php';
require_once __DIR__ . '/../repositories/MahasiswaRepository.php';
require_once __DIR__ . '/../models/ProdiModel.php';

class MahasiswaController
{
    private MahasiswaRepository $repo;
    private ProdiModel $prodiModel;

    public function __construct(MahasiswaRepository $repo, ProdiModel $prodiModel)
    {
        $this->repo       = $repo;
        $this->prodiModel = $prodiModel;
    }

    public function index(): void
    {
        $search    = trim($_GET['q'] ?? '');
        $mahasiswa = $this->repo->all($search);
        view('mahasiswa/index', compact('mahasiswa', 'search'));
    }

    public function create(): void
    {
        $prodi = $this->prodiModel->all();
        $old   = pull_old();
        $item  = null;
        view('mahasiswa/form', compact('prodi', 'old', 'item'));
    }

    public function store(): void
    {
        try {
            $mhs = new Mahasiswa();
            $this->fill($mhs);                 // setter memvalidasi tiap nilai
            $this->repo->create($mhs);
            flash('success', 'Data mahasiswa berhasil ditambahkan.');
            redirect('mahasiswa.php');
        } catch (InvalidArgumentException $e) {
            flash('danger', $e->getMessage());
            with_old($this->rawInput());
            redirect('mahasiswa.php?action=create');
        } catch (PDOException $e) {
            flash('danger', db_error_message($e));
            with_old($this->rawInput());
            redirect('mahasiswa.php?action=create');
        }
    }

    public function show(): void
    {
        $item = $this->repo->find((int)($_GET['id'] ?? 0));
        if (!$item) {
            flash('danger', 'Data mahasiswa tidak ditemukan.');
            redirect('mahasiswa.php');
        }
        view('mahasiswa/show', compact('item'));
    }

    public function edit(): void
    {
        $item = $this->repo->find((int)($_GET['id'] ?? 0));
        if (!$item) {
            flash('danger', 'Data mahasiswa tidak ditemukan.');
            redirect('mahasiswa.php');
        }
        $prodi = $this->prodiModel->all();
        $old   = pull_old();
        view('mahasiswa/form', compact('prodi', 'old', 'item'));
    }

    public function update(): void
    {
        $id = (int)($_POST['id'] ?? 0);
        try {
            $mhs = $this->repo->find($id);
            if (!$mhs) {
                flash('danger', 'Data mahasiswa tidak ditemukan.');
                redirect('mahasiswa.php');
            }
            $this->fill($mhs);
            $this->repo->update($mhs);
            flash('success', 'Data mahasiswa berhasil diubah.');
            redirect('mahasiswa.php');
        } catch (InvalidArgumentException $e) {
            flash('danger', $e->getMessage());
            with_old($this->rawInput());
            redirect('mahasiswa.php?action=edit&id=' . $id);
        } catch (PDOException $e) {
            flash('danger', db_error_message($e));
            with_old($this->rawInput());
            redirect('mahasiswa.php?action=edit&id=' . $id);
        }
    }

    public function destroy(): void
    {
        try {
            $this->repo->delete((int)($_POST['id'] ?? 0));
            flash('success', 'Data mahasiswa berhasil dihapus.');
        } catch (PDOException $e) {
            flash('danger', db_error_message($e));
        }
        redirect('mahasiswa.php');
    }

    // Isi objek Mahasiswa lewat setter (method chaining)
    private function fill(Mahasiswa $m): void
    {
        $m->setNim($_POST['nim'] ?? '')
          ->setNama($_POST['nama'] ?? '')
          ->setEmail($_POST['email'] ?? '')
          ->setProdiId((int)($_POST['prodi_id'] ?? 0))
          ->setAngkatan((int)($_POST['angkatan'] ?? 0))
          ->setStatus($_POST['status'] ?? 'aktif');
    }

    // Input mentah, dipakai untuk mengisi ulang form saat validasi gagal
    private function rawInput(): array
    {
        return [
            'nim'      => $_POST['nim'] ?? '',
            'nama'     => $_POST['nama'] ?? '',
            'email'    => $_POST['email'] ?? '',
            'prodi_id' => $_POST['prodi_id'] ?? '',
            'angkatan' => $_POST['angkatan'] ?? '',
            'status'   => $_POST['status'] ?? 'aktif',
        ];
    }
}
