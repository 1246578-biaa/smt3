<?php
// Fungsi bantu kecil yang dipakai controller dan view.

// Escape output agar aman dari XSS
function e($value): string
{
    return htmlspecialchars((string)($value ?? ''), ENT_QUOTES, 'UTF-8');
}

// Tampilkan view dibungkus header + footer
function view(string $path, array $data = []): void
{
    extract($data);
    require __DIR__ . '/../views/shared/header.php';
    require __DIR__ . '/../views/' . $path . '.php';
    require __DIR__ . '/../views/shared/footer.php';
}

function redirect(string $url): void
{
    header('Location: ' . $url);
    exit;
}

// Pesan sekali tampil (flash message)
function flash(string $type, string $message): void
{
    $_SESSION['flash'] = ['type' => $type, 'msg' => $message];
}

// Simpan input lama supaya form tidak kosong saat validasi gagal
function with_old(array $data): void
{
    $_SESSION['old'] = $data;
}

function pull_old(): array
{
    $old = $_SESSION['old'] ?? [];
    unset($_SESSION['old']);
    return $old;
}

// Ubah error database menjadi pesan yang mudah dipahami
function db_error_message(PDOException $e): string
{
    $code = $e->errorInfo[1] ?? 0;
    return match ($code) {
        1062    => 'Data dengan kode/NIM yang sama sudah ada.',
        1451    => 'Data tidak bisa dihapus karena masih dipakai data lain (FOREIGN KEY).',
        1452    => 'Prodi yang dipilih tidak ada.',
        default => 'Terjadi kesalahan pada database.',
    };
}