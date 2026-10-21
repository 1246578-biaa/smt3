<?php
require_once __DIR__ . '/../core/model.php';

class MatakuliahModel extends Model
{
    protected string $table = 'matakuliah';

    public function all(): array
    {
        return $this->db->query(
            "SELECT mk.*, p.nama AS prodi_nama
             FROM matakuliah mk
             JOIN prodi p ON mk.prodi_id = p.id
             ORDER BY mk.kode"
        )->fetchAll();
    }

    public function findWithProdi(int $id): ?array
    {
        $stmt = $this->db->prepare(
            "SELECT mk.*, p.kode AS prodi_kode, p.nama AS prodi_nama
             FROM matakuliah mk
             JOIN prodi p ON mk.prodi_id = p.id
             WHERE mk.id = :id"
        );
        $stmt->execute(['id' => $id]);
        return $stmt->fetch() ?: null;
    }

    public function create(array $d): bool
    {
        $stmt = $this->db->prepare(
            "INSERT INTO matakuliah (kode, nama, sks, prodi_id)
             VALUES (:kode, :nama, :sks, :prodi_id)"
        );
        return $stmt->execute([
            'kode' => $d['kode'], 'nama' => $d['nama'], 'sks' => $d['sks'], 'prodi_id' => $d['prodi_id'],
        ]);
    }

    public function update(int $id, array $d): bool
    {
        $stmt = $this->db->prepare(
            "UPDATE matakuliah
             SET kode = :kode, nama = :nama, sks = :sks, prodi_id = :prodi_id
             WHERE id = :id"
        );
        return $stmt->execute([
            'kode' => $d['kode'], 'nama' => $d['nama'], 'sks' => $d['sks'],
            'prodi_id' => $d['prodi_id'], 'id' => $id,
        ]);
    }
}
