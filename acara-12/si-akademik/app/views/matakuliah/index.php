<div class="d-flex justify-content-between align-items-center mb-3">
    <h3 class="mb-0">Data Mata Kuliah</h3>
    <a href="matakuliah.php?action=create" class="btn btn-primary">+ Tambah</a>
</div>

<table class="table table-bordered table-striped">
    <thead class="table-dark">
        <tr><th>No</th><th>Kode</th><th>Nama</th><th>SKS</th><th>Prodi</th><th>Aksi</th></tr>
    </thead>
    <tbody>
    <?php if (empty($matakuliah)): ?>
        <tr><td colspan="6" class="text-center">Belum ada data.</td></tr>
    <?php else: ?>
        <?php foreach ($matakuliah as $i => $mk): ?>
        <tr>
            <td><?= $i + 1 ?></td>
            <td><?= e($mk['kode']) ?></td>
            <td><?= e($mk['nama']) ?></td>
            <td><?= e($mk['sks']) ?></td>
            <td><?= e($mk['prodi_nama']) ?></td>
            <td>
                <a href="matakuliah.php?action=show&id=<?= (int)$mk['id'] ?>" class="btn btn-sm btn-info">Detail</a>
                <a href="matakuliah.php?action=edit&id=<?= (int)$mk['id'] ?>" class="btn btn-sm btn-warning">Edit</a>
                <form method="post" action="matakuliah.php?action=destroy" class="d-inline"
                      onsubmit="return confirm('Yakin hapus mata kuliah ini?')">
                    <input type="hidden" name="id" value="<?= (int)$mk['id'] ?>">
                    <button class="btn btn-sm btn-danger">Hapus</button>
                </form>
            </td>
        </tr>
        <?php endforeach; ?>
    <?php endif; ?>
    </tbody>
</table>
