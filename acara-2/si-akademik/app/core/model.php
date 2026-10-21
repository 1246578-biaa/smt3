<?php
// Base Model: mengurus koneksi PDO dan method umum untuk semua model.
class Model
{
    protected PDO $db;
    protected string $table = '';

    public function __construct()
    {
        // app/core -> naik 2 tingkat -> root proyek -> config/database.php
        $config = require __DIR__ . '/../../config/database.php';

        $dsn = "mysql:host={$config['host']};dbname={$config['dbname']};charset={$config['charset']}";

        $this->db = new PDO($dsn, $config['username'], $config['password'], [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ]);
    }

    // Ambil semua baris dari tabel milik model ini
    public function all(): array
    {
        return $this->db->query("SELECT * FROM {$this->table}")->fetchAll();
    }
}
