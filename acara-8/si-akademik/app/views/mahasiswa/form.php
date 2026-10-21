<?php
$isEdit = $item !== null;
$val = fn(string $k, $d = '') => e($old[$k] ?? $item[$k] ?? $d);
$selectedProdi = (int)($old['prodi_id'] ?? $item['prodi_id'] ?? 0);
?>
<h3><?= $isEdit ? 'Edit' : 'Tambah' ?> Mahasiswa</h3>

<form method="post" action="mahasiswa.php?action=<?= $isEdit ? 'update' : 'store' ?>" class="mt-3" style="max-width:520px">
    <?php if ($isEdit): ?>
        <input type="hidden" name="id" value="<?= (int)$item['id'] ?>">
    <?php endif; ?>

    <div class="mb-3">
        <label class="form-label">NIM</label>
        <input type="text" name="nim" class="form-control" value="<?= $val('nim') ?>" required>
    </div>
    <div class="mb-3">
        <label class="form-label">Nama</label>
        <input type="text" name="nama" class="form-control" value="<?= $val('nama') ?>" required>
    </div>
    <div class="mb-3">
        <label class="form-label">Email</label>
        <input type="email" name="email" class="form-control" value="<?= $val('email') ?>" required>
    </div>
    <div class="mb-3">
        <label class="form-label">Prodi</label>
        <select name="prodi_id" class="form-select" required>
            <option value="">-- Pilih Prodi --</option>
            <?php foreach ($prodi as $p): ?>
                <option value="<?= (int)$p['id'] ?>" <?= $selectedProdi === (int)$p['id'] ? 'selected' : '' ?>>
                    <?= e($p['kode']) ?> - <?= e($p['nama']) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="mb-3">
        <label class="form-label">Angkatan</label>
        <input type="number" name="angkatan" class="form-control" value="<?= $val('angkatan', date('Y')) ?>" required>
    </div>

    <button class="btn btn-primary">Simpan</button>
    <a href="mahasiswa.php" class="btn btn-secondary">Batal</a>
</form>
