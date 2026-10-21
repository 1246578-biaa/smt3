<?php
require_once __DIR__ . '/database.php';

// Base Model: method umum yang diwarisi semua model.
class Model
{
    protected PDO $db;
    protected string $table = '';   // diisi oleh kelas turunan (nama tabel tidak bisa di-bind, jadi tidak dari input user)

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    public function all(): array
    {
        return $this->db->query("SELECT * FROM {$this->table} ORDER BY id")->fetchAll();
    }

    public function find(int $id): ?array
    {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE id = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch() ?: null;
    }

    public function delete(int $id): bool
    {
        $stmt = $this->db->prepare("DELETE FROM {$this->table} WHERE id = :id");
        return $stmt->execute(['id' => $id]);
    }
}
