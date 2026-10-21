<?php

class Mahasiswa
{
    public const STATUS = ['aktif', 'cuti', 'lulus'];

    private ?int   $id       = null;
    private string $nim      = '';
    private string $nama     = '';
    private string $email    = '';
    private int    $prodiId  = 0;
    private int    $angkatan = 0;
    private string $status   = 'aktif';

    private ?string $prodiKode = null;
    private ?string $prodiNama = null;
    private ?string $createdAt = null;
    private ?string $updatedAt = null;

    public static function fromArray(array $row): self
    {
        $m = new self();
        $m->id        = isset($row['id']) ? (int)$row['id'] : null;
        $m->nim       = (string)($row['nim'] ?? '');
        $m->nama      = (string)($row['nama'] ?? '');
        $m->email     = (string)($row['email'] ?? '');
        $m->prodiId   = (int)($row['prodi_id'] ?? 0);
        $m->angkatan  = (int)($row['angkatan'] ?? 0);
        $m->status    = (string)($row['status'] ?? 'aktif');
        $m->prodiKode = $row['prodi_kode'] ?? null;
        $m->prodiNama = $row['prodi_nama'] ?? null;
        $m->createdAt = $row['created_at'] ?? null;
        $m->updatedAt = $row['updated_at'] ?? null;
        return $m;
    }

    public function getId(): ?int         { return $this->id; }
    public function getNim(): string      { return $this->nim; }
    public function getNama(): string     { return $this->nama; }
    public function getEmail(): string    { return $this->email; }
    public function getProdiId(): int     { return $this->prodiId; }
    public function getAngkatan(): int    { return $this->angkatan; }
    public function getStatus(): string   { return $this->status; }
    public function getProdiKode(): ?string { return $this->prodiKode; }
    public function getProdiNama(): ?string { return $this->prodiNama; }
    public function getCreatedAt(): ?string { return $this->createdAt; }
    public function getUpdatedAt(): ?string { return $this->updatedAt; }

    public function setNim(string $nim): self
    {
        $nim = trim($nim);
        if ($nim === '') {
            throw new InvalidArgumentException('NIM tidak boleh kosong.');
        }
        if (!ctype_digit($nim)) {
            throw new InvalidArgumentException('NIM harus berupa angka.');
        }
        if (strlen($nim) > 20) {
            throw new InvalidArgumentException('NIM maksimal 20 digit.');
        }
        $this->nim = $nim;
        return $this;
    }

    public function setNama(string $nama): self
    {
        $nama = trim($nama);
        if ($nama === '') {
            throw new InvalidArgumentException('Nama tidak boleh kosong.');
        }
        $panjang = function_exists('mb_strlen') ? mb_strlen($nama) : strlen($nama);
        if ($panjang > 100) {
            throw new InvalidArgumentException('Nama maksimal 100 karakter.');
        }
        $this->nama = $nama;
        return $this;
    }

    public function setEmail(string $email): self
    {
        $email = trim($email);
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new InvalidArgumentException('Format email tidak valid.');
        }
        $this->email = $email;
        return $this;
    }

    public function setProdiId(int $prodiId): self
    {
        if ($prodiId <= 0) {
            throw new InvalidArgumentException('Prodi wajib dipilih.');
        }
        $this->prodiId = $prodiId;
        return $this;
    }

    public function setAngkatan(int $angkatan): self
    {
        if ($angkatan < 1990 || $angkatan > (int)date('Y') + 1) {
            throw new InvalidArgumentException('Angkatan tidak valid.');
        }
        $this->angkatan = $angkatan;
        return $this;
    }

    public function setStatus(string $status): self
    {
        if (!in_array($status, self::STATUS, true)) {
            throw new InvalidArgumentException('Status harus aktif, cuti, atau lulus.');
        }
        $this->status = $status;
        return $this;
    }
}
