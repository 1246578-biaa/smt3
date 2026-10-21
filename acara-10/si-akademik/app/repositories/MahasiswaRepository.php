<?php
require_once __DIR__ . '/../core/Basemodel.php';
require_once __DIR__ . '/../models/Mahasiswa.php';

class MahasiswaRepository extends BaseModel
{
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

        return array_map(fn(array $row) => Mahasiswa::fromArray($row), $this->fetchAll($sql, $params));
    }

    public function find(int $id): ?Mahasiswa
    {
        $row = $this->fetchOne(
            "SELECT m.*, p.kode AS prodi_kode, p.nama AS prodi_nama
             FROM mahasiswa m
             JOIN prodi p ON m.prodi_id = p.id
             WHERE m.id = :id",
            ['id' => $id]
        );

        return $row ? Mahasiswa::fromArray($row) : null;
    }

    public function create(Mahasiswa $m): int
    {
        $this->execute(
            "INSERT INTO mahasiswa (nim, nama, email, prodi_id, angkatan, status)
             VALUES (:nim, :nama, :email, :prodi_id, :angkatan, :status)",
            [
                'nim'      => $m->getNim(),
                'nama'     => $m->getNama(),
                'email'    => $m->getEmail(),
                'prodi_id' => $m->getProdiId(),
                'angkatan' => $m->getAngkatan(),
                'status'   => $m->getStatus(),
            ]
        );
        return $this->lastInsertId();
    }

    public function update(Mahasiswa $m): bool
    {
        if ($m->getId() === null) {
            throw new LogicException('Mahasiswa belum punya id, tidak bisa diupdate.');
        }
        return $this->execute(
            "UPDATE mahasiswa
             SET nim = :nim, nama = :nama, email = :email,
                 prodi_id = :prodi_id, angkatan = :angkatan, status = :status
             WHERE id = :id",
            [
                'nim'      => $m->getNim(),
                'nama'     => $m->getNama(),
                'email'    => $m->getEmail(),
                'prodi_id' => $m->getProdiId(),
                'angkatan' => $m->getAngkatan(),
                'status'   => $m->getStatus(),
                'id'       => $m->getId(),
            ]
        );
    }

    public function delete(int $id): bool
    {
        return $this->execute("DELETE FROM mahasiswa WHERE id = :id", ['id' => $id]);
    }
}