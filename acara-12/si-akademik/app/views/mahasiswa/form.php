<?php
$isEdit   = $item !== null;
// Nilai form: input lama (jika validasi gagal) -> data objek -> default
$nim      = $old['nim']      ?? ($item?->getNim()      ?? '');
$nama     = $old['nama']     ?? ($item?->getNama()     ?? '');
$email    = $old['email']    ?? ($item?->getEmail()    ?? '');
$prodiId  = (int)($old['prodi_id'] ?? ($item?->getProdiId() ?? 0));
$angkatan = $old['angkatan'] ?? ($item?->getAngkatan() ?? date('Y'));
$status   = $old['status']   ?? ($item?->getStatus()   ?? 'aktif');
?>
<h3><?= $isEdit ? 'Edit' : 'Tambah' ?> Mahasiswa</h3>

<form method="post" action="mahasiswa.php?action=<?= $isEdit ? 'update' : 'store' ?>" class="mt-3" style="max-width:520px">
    <?php if ($isEdit): ?>
        <input type="hidden" name="id" value="<?= (int)$item->getId() ?>">
    <?php endif; ?>

    <div class="mb-3">
        <label class="form-label">NIM</label>
        <input type="text" name="nim" class="form-control" value="<?= e($nim) ?>" required>
    </div>
    <div class="mb-3">
        <label class="form-label">Nama</label>
        <input type="text" name="nama" class="form-control" value="<?= e($nama) ?>" required>
    </div>
    <div class="mb-3">
        <label class="form-label">Email</label>
        <input type="email" name="email" class="form-control" value="<?= e($email) ?>" required>
    </div>
    <div class="mb-3">
        <label class="form-label">Prodi</label>
        <select name="prodi_id" class="form-select" required>
            <option value="">-- Pilih Prodi --</option>
            <?php foreach ($prodi as $p): ?>
                <option value="<?= (int)$p['id'] ?>" <?= $prodiId === (int)$p['id'] ? 'selected' : '' ?>>
                    <?= e($p['kode']) ?> - <?= e($p['nama']) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="mb-3">
        <label class="form-label">Angkatan</label>
        <input type="number" name="angkatan" class="form-control" value="<?= e($angkatan) ?>" required>
    </div>
    <div class="mb-3">
        <label class="form-label">Status</label>
        <select name="status" class="form-select">
            <?php foreach (Mahasiswa::STATUS as $s): ?>
                <option value="<?= e($s) ?>" <?= $status === $s ? 'selected' : '' ?>><?= e($s) ?></option>
            <?php endforeach; ?>
        </select>
    </div>

    <button class="btn btn-primary">Simpan</button>
    <a href="mahasiswa.php" class="btn btn-secondary">Batal</a>
</form>
