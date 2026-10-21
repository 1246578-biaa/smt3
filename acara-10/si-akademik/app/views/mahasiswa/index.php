<div class="d-flex justify-content-between align-items-center mb-3">
    <h3 class="mb-0">Data Mahasiswa</h3>
    <a href="mahasiswa.php?action=create" class="btn btn-primary">+ Tambah</a>
</div>

<form method="get" action="mahasiswa.php" class="row g-2 mb-3">
    <div class="col-auto">
        <input type="text" name="q" class="form-control" placeholder="Cari nama atau NIM" value="<?= e($search) ?>">
    </div>
    <div class="col-auto">
        <button class="btn btn-outline-primary">Cari</button>
        <?php if ($search !== ''): ?>
            <a href="mahasiswa.php" class="btn btn-outline-secondary">Reset</a>
        <?php endif; ?>
    </div>
</form>

<table class="table table-bordered table-striped">
    <thead class="table-dark">
        <tr>
            <th>No</th><th>NIM</th><th>Nama</th><th>Email</th>
            <th>Prodi</th><th>Angkatan</th><th>Status</th><th>Aksi</th>
        </tr>
    </thead>
    <tbody>
    <?php if (empty($mahasiswa)): ?>
        <tr><td colspan="8" class="text-center">Belum ada data.</td></tr>
    <?php else: ?>
        <?php foreach ($mahasiswa as $i => $m): ?>
        <tr>
            <td><?= $i + 1 ?></td>
            <td><?= e($m->getNim()) ?></td>
            <td><?= e($m->getNama()) ?></td>
            <td><?= e($m->getEmail()) ?></td>
            <td><?= e($m->getProdiNama()) ?></td>
            <td><?= e($m->getAngkatan()) ?></td>
            <td><?= e($m->getStatus()) ?></td>
            <td>
                <a href="mahasiswa.php?action=show&id=<?= (int)$m->getId() ?>" class="btn btn-sm btn-info">Detail</a>
                <a href="mahasiswa.php?action=edit&id=<?= (int)$m->getId() ?>" class="btn btn-sm btn-warning">Edit</a>
                <form method="post" action="mahasiswa.php?action=destroy" class="d-inline"
                      onsubmit="return confirm('Yakin hapus data ini?')">
                    <input type="hidden" name="id" value="<?= (int)$m->getId() ?>">
                    <button class="btn btn-sm btn-danger">Hapus</button>
                </form>
            </td>
        </tr>
        <?php endforeach; ?>
    <?php endif; ?>
    </tbody>
</table>
