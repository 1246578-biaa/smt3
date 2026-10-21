<?php
require_once __DIR__ . '/../models/Mahasiswa.php';

// Repository: satu-satunya kelas yang menulis SQL untuk mahasiswa.
// Koneksi (PDO dari class Database) DISUNTIKKAN lewat constructor (constructor injection),
// jadi repository tidak membuat koneksi sendiri.
class MahasiswaRepository
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    /** @return Mahasiswa[] */
    public function all(?string $search = null): array
    {
        $sql = "SELECT m.*, p.kode AS prodi_kode, p.nama AS prodi_nama
                FROM mahasiswa m
                JOIN prodi p ON m.prodi_id = p.id";
        $params = [];

        if ($search !== null && $search !== '') {
            $sql .= " WHERE m.nama LIKE :q1 OR m.nim LIKE :q2";
            $params = ['q1' => "%{$search}%", 'q2' => "%{$search}%"];
        }

        $sql .= " ORDER BY m.nim";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);

        return array_map(fn(array $row) => Mahasiswa::fromArray($row), $stmt->fetchAll());
    }

    public function find(int $id): ?Mahasiswa
    {
        $stmt = $this->pdo->prepare(
            "SELECT m.*, p.kode AS prodi_kode, p.nama AS prodi_nama
             FROM mahasiswa m
             JOIN prodi p ON m.prodi_id = p.id
             WHERE m.id = :id"
        );
        $stmt->execute(['id' => $id]);
        $row = $stmt->fetch();

        return $row ? Mahasiswa::fromArray($row) : null;
    }

    public function create(Mahasiswa $m): bool
    {
        $stmt = $this->pdo->prepare(
            "INSERT INTO mahasiswa (nim, nama, email, prodi_id, angkatan, status)
             VALUES (:nim, :nama, :email, :prodi_id, :angkatan, :status)"
        );
        return $stmt->execute([
            'nim'      => $m->getNim(),
            'nama'     => $m->getNama(),
            'email'    => $m->getEmail(),
            'prodi_id' => $m->getProdiId(),
            'angkatan' => $m->getAngkatan(),
            'status'   => $m->getStatus(),
        ]);
    }

    public function update(Mahasiswa $m): bool
    {
        if ($m->getId() === null) {
            throw new LogicException('Mahasiswa belum punya id, tidak bisa diupdate.');
        }
        $stmt = $this->pdo->prepare(
            "UPDATE mahasiswa
             SET nim = :nim, nama = :nama, email = :email,
                 prodi_id = :prodi_id, angkatan = :angkatan, status = :status
             WHERE id = :id"
        );
        return $stmt->execute([
            'nim'      => $m->getNim(),
            'nama'     => $m->getNama(),
            'email'    => $m->getEmail(),
            'prodi_id' => $m->getProdiId(),
            'angkatan' => $m->getAngkatan(),
            'status'   => $m->getStatus(),
            'id'       => $m->getId(),
        ]);
    }

    public function delete(int $id): bool
    {
        $stmt = $this->pdo->prepare("DELETE FROM mahasiswa WHERE id = :id");
        return $stmt->execute(['id' => $id]);
    }
}
