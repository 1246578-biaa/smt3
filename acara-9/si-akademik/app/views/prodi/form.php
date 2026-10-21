<?php
$isEdit = $item !== null;
$val = fn(string $k, $d = '') => e($old[$k] ?? $item[$k] ?? $d);
?>
<h3><?= $isEdit ? 'Edit' : 'Tambah' ?> Program Studi</h3>

<form method="post" action="prodi.php?action=<?= $isEdit ? 'update' : 'store' ?>" class="mt-3" style="max-width:520px">
    <?php if ($isEdit): ?>
        <input type="hidden" name="id" value="<?= (int)$item['id'] ?>">
    <?php endif; ?>

    <div class="mb-3">
        <label class="form-label">Kode</label>
        <input type="text" name="kode" class="form-control" maxlength="10" value="<?= $val('kode') ?>" required>
    </div>
    <div class="mb-3">
        <label class="form-label">Nama</label>
        <input type="text" name="nama" class="form-control" maxlength="100" value="<?= $val('nama') ?>" required>
    </div>

    <button class="btn btn-primary">Simpan</button>
    <a href="prodi.php" class="btn btn-secondary">Batal</a>
</form>
