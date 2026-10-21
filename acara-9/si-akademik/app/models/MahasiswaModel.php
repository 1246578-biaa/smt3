<?php
require_once __DIR__ . '/../core/model.php';

class MahasiswaModel extends Model
{
    protected string $table = 'mahasiswa';

    // Daftar mahasiswa + nama prodi (JOIN). Bisa dicari dengan LIKE (Tugas Mandiri).
    public function all(?string $search = null): array
    {
        $sql = "SELECT m.*, p.nama AS prodi_nama
                FROM mahasiswa m
                JOIN prodi p ON m.prodi_id = p.id";
        $params = [];

        if ($search !== null && $search !== '') {
            // Dengan EMULATE_PREPARES=false, nama parameter tidak boleh dipakai dua kali
            $sql .= " WHERE m.nama LIKE :q1 OR m.nim LIKE :q2";
            $params = ['q1' => "%{$search}%", 'q2' => "%{$search}%"];
        }

        $sql .= " ORDER BY m.nim";
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }

    // Satu mahasiswa + data prodinya (JOIN) untuk halaman detail
    public function findWithProdi(int $id): ?array
    {
        $stmt = $this->db->prepare(
            "SELECT m.*, p.kode AS prodi_kode, p.nama AS prodi_nama
             FROM mahasiswa m
             JOIN prodi p ON m.prodi_id = p.id
             WHERE m.id = :id"
        );
        $stmt->execute(['id' => $id]);
        return $stmt->fetch() ?: null;
    }

    public function create(array $d): bool
    {
        $stmt = $this->db->prepare(
            "INSERT INTO mahasiswa (nim, nama, email, prodi_id, angkatan)
             VALUES (:nim, :nama, :email, :prodi_id, :angkatan)"
        );
        return $stmt->execute([
            'nim' => $d['nim'], 'nama' => $d['nama'], 'email' => $d['email'],
            'prodi_id' => $d['prodi_id'], 'angkatan' => $d['angkatan'],
        ]);
    }

    public function update(int $id, array $d): bool
    {
        $stmt = $this->db->prepare(
            "UPDATE mahasiswa
             SET nim = :nim, nama = :nama, email = :email, prodi_id = :prodi_id, angkatan = :angkatan
             WHERE id = :id"
        );
        return $stmt->execute([
            'nim' => $d['nim'], 'nama' => $d['nama'], 'email' => $d['email'],
            'prodi_id' => $d['prodi_id'], 'angkatan' => $d['angkatan'], 'id' => $id,
        ]);
    }
}
