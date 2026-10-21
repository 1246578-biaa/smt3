<?php
require_once __DIR__ . '/../core/BaseController.php';
require_once __DIR__ . '/../repositories/MahasiswaRepository.php';
require_once __DIR__ . '/../models/ProdiModel.php';

class MahasiswaController extends BaseController
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
        $this->view('mahasiswa/index', compact('mahasiswa', 'search'));
    }

    public function create(): void
    {
        $prodi = $this->prodiModel->all();
        $old   = $this->pullOld();
        $item  = null;
        $this->view('mahasiswa/form', compact('prodi', 'old', 'item'));
    }

    public function store(): void
    {
        try {
            $mhs = new Mahasiswa();
            $this->fill($mhs);
            $this->repo->create($mhs);
            $this->flash('success', 'Data mahasiswa berhasil ditambahkan.');
            $this->redirect('mahasiswa.php');
        } catch (InvalidArgumentException $e) {
            $this->flash('danger', $e->getMessage());
            $this->withOld($this->rawInput());
            $this->redirect('mahasiswa.php?action=create');
        } catch (PDOException $e) {
            $this->flash('danger', db_error_message($e));
            $this->withOld($this->rawInput());
            $this->redirect('mahasiswa.php?action=create');
        }
    }

    public function show(): void
    {
        $item = $this->repo->find((int)($_GET['id'] ?? 0));
        if (!$item) {
            $this->flash('danger', 'Data mahasiswa tidak ditemukan.');
            $this->redirect('mahasiswa.php');
        }
        $this->view('mahasiswa/show', compact('item'));
    }

    public function edit(): void
    {
        $item = $this->repo->find((int)($_GET['id'] ?? 0));
        if (!$item) {
            $this->flash('danger', 'Data mahasiswa tidak ditemukan.');
            $this->redirect('mahasiswa.php');
        }
        $prodi = $this->prodiModel->all();
        $old   = $this->pullOld();
        $this->view('mahasiswa/form', compact('prodi', 'old', 'item'));
    }

    public function update(): void
    {
        $id = (int)($_POST['id'] ?? 0);
        try {
            $mhs = $this->repo->find($id);
            if (!$mhs) {
                $this->flash('danger', 'Data mahasiswa tidak ditemukan.');
                $this->redirect('mahasiswa.php');
            }
            $this->fill($mhs);
            $this->repo->update($mhs);
            $this->flash('success', 'Data mahasiswa berhasil diubah.');
            $this->redirect('mahasiswa.php');
        } catch (InvalidArgumentException $e) {
            $this->flash('danger', $e->getMessage());
            $this->withOld($this->rawInput());
            $this->redirect('mahasiswa.php?action=edit&id=' . $id);
        } catch (PDOException $e) {
            $this->flash('danger', db_error_message($e));
            $this->withOld($this->rawInput());
            $this->redirect('mahasiswa.php?action=edit&id=' . $id);
        }
    }

    public function destroy(): void
    {
        try {
            $this->repo->delete((int)($_POST['id'] ?? 0));
            $this->flash('success', 'Data mahasiswa berhasil dihapus.');
        } catch (PDOException $e) {
            $this->flash('danger', db_error_message($e));
        }
        $this->redirect('mahasiswa.php');
    }

    private function fill(Mahasiswa $m): void
    {
        $m->setNim($_POST['nim'] ?? '')
          ->setNama($_POST['nama'] ?? '')
          ->setEmail($_POST['email'] ?? '')
          ->setProdiId((int)($_POST['prodi_id'] ?? 0))
          ->setAngkatan((int)($_POST['angkatan'] ?? 0))
          ->setStatus($_POST['status'] ?? 'aktif');
    }

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