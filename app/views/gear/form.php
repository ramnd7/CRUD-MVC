<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= e($title) ?></title>
    <link rel="stylesheet" href="<?= e(BASE_URL . '/css/crud.css') ?>">
</head>
<body>
<div class="crud-box">
    <div class="crud-header">
        <h1>Pesona Rental Gear</h1>
        <p><?= e($title) ?> — MVC</p>
    </div>
    <div class="crud-content">
        <?php if ($error !== ''): ?>
            <p role="alert" style="color:#c0392b"><?= e($error) ?></p>
        <?php endif; ?>
        <form action="<?= e($action) ?>" method="post" enctype="multipart/form-data" class="form-crud">
            <input type="hidden" name="_token" value="<?= e($csrfToken) ?>">

            <label for="nama_gear">Nama Gear</label>
            <input id="nama_gear" type="text" name="nama_gear"
                   value="<?= e($gear['nama_gear']) ?>" required>

            <label for="merek">Merek</label>
            <input id="merek" type="text" name="merek"
                   value="<?= e($gear['merek']) ?>" required>

            <label for="id_kategori">Kategori</label>
            <select id="id_kategori" name="id_kategori" required>
                <option value="">-- Pilih Kategori --</option>
                <?php foreach ($categories as $category): ?>
                    <option value="<?= (int) $category['id_kategori'] ?>"
                        <?= (string) $category['id_kategori'] === (string) $gear['id_kategori'] ? 'selected' : '' ?>>
                        <?= e($category['nama_kategori']) ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <label for="harga_sewa">Harga Sewa / Hari</label>
            <input id="harga_sewa" type="number" min="0" name="harga_sewa"
                   value="<?= e($gear['harga_sewa']) ?>" required>

            <label for="stok">Stok</label>
            <input id="stok" type="number" min="0" name="stok"
                   value="<?= e($gear['stok']) ?>" required>

            <label for="status">Status</label>
            <select id="status" name="status">
                <?php foreach (['Tersedia', 'Disewa', 'Maintenance'] as $status): ?>
                    <option value="<?= e($status) ?>"
                        <?= $gear['status'] === $status ? 'selected' : '' ?>>
                        <?= e($status) ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <label for="deskripsi">Deskripsi</label>
            <textarea id="deskripsi" name="deskripsi" rows="4"><?= e($gear['deskripsi']) ?></textarea>

            <?php if ($gear['foto'] !== ''): ?>
                <label>Foto Saat Ini</label>
                <img src="<?= e(BASE_URL . '/gear/uploads/' . rawurlencode($gear['foto'])) ?>"
                     alt="<?= e($gear['nama_gear']) ?>">
            <?php endif; ?>

            <label for="foto"><?= $gear['foto'] === '' ? 'Foto Gear' : 'Ganti Foto (Opsional)' ?></label>
            <input id="foto" type="file" name="foto" accept=".jpg,.jpeg,.png"
                   <?= $gear['foto'] === '' ? 'required' : '' ?>>

            <br><br>
            <button class="btn-simpan" type="submit">Simpan</button>
            <a class="btn-kembali" href="<?= e(BASEURL . '/index.php?url=gear') ?>">Kembali</a>
        </form>
    </div>
    <div class="crud-footer">Sistem Rental Outdoor Gear</div>
</div>
</body>
</html>
