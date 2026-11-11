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
        <p><?= e($title) ?> - MVC</p>
    </div>

    <div class="crud-content">
        <?php if ($error !== ''): ?>
            <p role="alert" style="color:#c0392b"><?= e($error) ?></p>
        <?php endif; ?>

        <form action="<?= e($action) ?>" method="post" class="form-crud">
            <input type="hidden" name="_token" value="<?= e($csrfToken) ?>">

            <label for="nama_kategori">Nama Kategori</label>
            <input
                id="nama_kategori"
                type="text"
                name="nama_kategori"
                value="<?= e($kategori['nama_kategori']) ?>"
                placeholder="Contoh: Carrier"
                required
                maxlength="100">

            <br><br>
            <button class="btn-simpan" type="submit">Simpan</button>
            <a class="btn-kembali" href="<?= e(BASEURL . '/index.php?url=kategori') ?>">
                Kembali
            </a>
        </form>
    </div>

    <div class="crud-footer">Sistem Rental Outdoor Gear</div>
</div>
</body>
</html>
