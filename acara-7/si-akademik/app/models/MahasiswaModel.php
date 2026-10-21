<?php
require_once __DIR__ . '/../core/model.php';

class MahasiswaModel extends Model
{
    protected string $table = 'mahasiswa';

    public function all(): array
    {
        $sql = "SELECT m.*, p.nama AS nama_prodi
                FROM mahasiswa m
                JOIN prodi p ON m.prodi_id = p.id
                ORDER BY m.nim";

        return $this->db->query($sql)->fetchAll();
    }
}
