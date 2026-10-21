<?php
$isEdit = $item !== null;
$val = fn(string $k, $d = '') => e($old[$k] ?? $item[$k] ?? $d);
$selectedProdi = (int)($old['prodi_id'] ?? $item['prodi_id'] ?? 0);
?>
<h3><?= $isEdit ? 'Edit' : 'Tambah' ?> Mata Kuliah</h3>

<form method="post" action="matakuliah.php?action=<?= $isEdit ? 'update' : 'store' ?>" class="mt-3" style="max-width:520px">
    <?php if ($isEdit): ?>
        <input type="hidden" name="id" value="<?= (int)$item['id'] ?>">
    <?php endif; ?>

    <div class="mb-3">
        <label class="form-label">Kode</label>
        <input type="text" name="kode" class="form-control" maxlength="10" value="<?= $val('kode') ?>" required>
    </div>
    <div class="mb-3">
        <label class="form-label">Nama</label>
        <input type="text" name="nama" class="form-control" maxlength="150" value="<?= $val('nama') ?>" required>
    </div>
    <div class="mb-3">
        <label class="form-label">SKS</label>
        <input type="number" name="sks" class="form-control" min="1" max="6" value="<?= $val('sks') ?>" required>
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

    <button class="btn btn-primary">Simpan</button>
    <a href="matakuliah.php" class="btn btn-secondary">Batal</a>
</form>
