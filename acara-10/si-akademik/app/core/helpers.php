<?php

function e($value): string
{
    return htmlspecialchars((string)($value ?? ''), ENT_QUOTES, 'UTF-8');
}

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