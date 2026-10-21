<h3>Detail Mahasiswa</h3>

<table class="table table-bordered mt-3" style="max-width:560px">
    <tr><th style="width:35%">NIM</th><td><?= e($item->getNim()) ?></td></tr>
    <tr><th>Nama</th><td><?= e($item->getNama()) ?></td></tr>
    <tr><th>Email</th><td><?= e($item->getEmail()) ?></td></tr>
    <tr><th>Prodi</th><td><?= e($item->getProdiKode()) ?> - <?= e($item->getProdiNama()) ?></td></tr>
    <tr><th>Angkatan</th><td><?= e($item->getAngkatan()) ?></td></tr>
    <tr><th>Status</th><td><?= e($item->getStatus()) ?></td></tr>
    <tr><th>Dibuat</th><td><?= e($item->getCreatedAt()) ?></td></tr>
    <tr><th>Diubah</th><td><?= e($item->getUpdatedAt()) ?></td></tr>
</table>

<a href="mahasiswa.php?action=edit&id=<?= (int)$item->getId() ?>" class="btn btn-warning">Edit</a>
<a href="mahasiswa.php" class="btn btn-secondary">Kembali</a>
