<h3>Detail Mahasiswa</h3>

<table class="table table-bordered mt-3" style="max-width:560px">
    <tr><th style="width:35%">NIM</th><td><?= e($item['nim']) ?></td></tr>
    <tr><th>Nama</th><td><?= e($item['nama']) ?></td></tr>
    <tr><th>Email</th><td><?= e($item['email']) ?></td></tr>
    <tr><th>Prodi</th><td><?= e($item['prodi_kode']) ?> - <?= e($item['prodi_nama']) ?></td></tr>
    <tr><th>Angkatan</th><td><?= e($item['angkatan']) ?></td></tr>
    <tr><th>Status</th><td><?= e($item['status'] ?? '-') ?></td></tr>
    <tr><th>Dibuat</th><td><?= e($item['created_at']) ?></td></tr>
    <tr><th>Diubah</th><td><?= e($item['updated_at']) ?></td></tr>
</table>

<a href="mahasiswa.php?action=edit&id=<?= (int)$item['id'] ?>" class="btn btn-warning">Edit</a>
<a href="mahasiswa.php" class="btn btn-secondary">Kembali</a>
