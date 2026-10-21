<?php
require_once __DIR__ . '/../core/model.php';

class ProdiModel extends Model
{
    protected string $table = 'prodi';

    public function all(): array
    {
        return $this->db->query("SELECT * FROM prodi ORDER BY kode")->fetchAll();
    }

    public function mahasiswa(int $id): array
    {
        $stmt = $this->db->prepare(
            "SELECT nim, nama, angkatan FROM mahasiswa WHERE prodi_id = :id ORDER BY nim"
        );
        $stmt->execute(['id' => $id]);
        return $stmt->fetchAll();
    }

    public function create(array $d): bool
    {
        $stmt = $this->db->prepare("INSERT INTO prodi (kode, nama) VALUES (:kode, :nama)");
        return $stmt->execute(['kode' => $d['kode'], 'nama' => $d['nama']]);
    }

    public function update(int $id, array $d): bool
    {
        $stmt = $this->db->prepare("UPDATE prodi SET kode = :kode, nama = :nama WHERE id = :id");
        return $stmt->execute(['kode' => $d['kode'], 'nama' => $d['nama'], 'id' => $id]);
    }
}
