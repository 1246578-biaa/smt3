<div class="d-flex justify-content-between align-items-center mb-3">
    <h3 class="mb-0">Data Program Studi</h3>
    <a href="prodi.php?action=create" class="btn btn-primary">+ Tambah</a>
</div>

<table class="table table-bordered table-striped">
    <thead class="table-dark">
        <tr><th>No</th><th>Kode</th><th>Nama</th><th>Aksi</th></tr>
    </thead>
    <tbody>
    <?php if (empty($prodi)): ?>
        <tr><td colspan="4" class="text-center">Belum ada data.</td></tr>
    <?php else: ?>
        <?php foreach ($prodi as $i => $p): ?>
        <tr>
            <td><?= $i + 1 ?></td>
            <td><?= e($p['kode']) ?></td>
            <td><?= e($p['nama']) ?></td>
            <td>
                <a href="prodi.php?action=show&id=<?= (int)$p['id'] ?>" class="btn btn-sm btn-info">Detail</a>
                <a href="prodi.php?action=edit&id=<?= (int)$p['id'] ?>" class="btn btn-sm btn-warning">Edit</a>
                <form method="post" action="prodi.php?action=destroy" class="d-inline"
                      onsubmit="return confirm('Yakin hapus prodi ini?')">
                    <input type="hidden" name="id" value="<?= (int)$p['id'] ?>">
                    <button class="btn btn-sm btn-danger">Hapus</button>
                </form>
            </td>
        </tr>
        <?php endforeach; ?>
    <?php endif; ?>
    </tbody>
</table>
