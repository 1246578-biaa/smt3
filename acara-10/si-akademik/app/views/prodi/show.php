<h3>Detail Program Studi</h3>

<table class="table table-bordered mt-3" style="max-width:560px">
    <tr><th style="width:35%">Kode</th><td><?= e($item['kode']) ?></td></tr>
    <tr><th>Nama</th><td><?= e($item['nama']) ?></td></tr>
    <tr><th>Jumlah Mahasiswa</th><td><?= count($mahasiswa) ?></td></tr>
</table>

<h5 class="mt-4">Mahasiswa di prodi ini</h5>
<table class="table table-bordered table-striped" style="max-width:560px">
    <thead class="table-dark"><tr><th>NIM</th><th>Nama</th><th>Angkatan</th></tr></thead>
    <tbody>
    <?php if (empty($mahasiswa)): ?>
        <tr><td colspan="3" class="text-center">Belum ada mahasiswa.</td></tr>
    <?php else: ?>
        <?php foreach ($mahasiswa as $m): ?>
        <tr>
            <td><?= e($m['nim']) ?></td>
            <td><?= e($m['nama']) ?></td>
            <td><?= e($m['angkatan']) ?></td>
        </tr>
        <?php endforeach; ?>
    <?php endif; ?>
    </tbody>
</table>

<a href="prodi.php?action=edit&id=<?= (int)$item['id'] ?>" class="btn btn-warning">Edit</a>
<a href="prodi.php" class="btn btn-secondary">Kembali</a>
