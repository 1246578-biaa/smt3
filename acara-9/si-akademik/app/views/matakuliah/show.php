<h3>Detail Mata Kuliah</h3>

<table class="table table-bordered mt-3" style="max-width:560px">
    <tr><th style="width:35%">Kode</th><td><?= e($item['kode']) ?></td></tr>
    <tr><th>Nama</th><td><?= e($item['nama']) ?></td></tr>
    <tr><th>SKS</th><td><?= e($item['sks']) ?></td></tr>
    <tr><th>Prodi</th><td><?= e($item['prodi_kode']) ?> - <?= e($item['prodi_nama']) ?></td></tr>
    <tr><th>Dibuat</th><td><?= e($item['created_at']) ?></td></tr>
    <tr><th>Diubah</th><td><?= e($item['updated_at']) ?></td></tr>
</table>

<a href="matakuliah.php?action=edit&id=<?= (int)$item['id'] ?>" class="btn btn-warning">Edit</a>
<a href="matakuliah.php" class="btn btn-secondary">Kembali</a>
