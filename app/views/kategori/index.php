<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Kelola Kategori</title>
    <link rel="stylesheet" href="<?= e(BASE_URL . '/css/crud.css') ?>">
</head>
<body>
<div class="crud-box">
    <div class="crud-header">
        <h1>Pesona Outdoor</h1>
        <p>Kelola Data Kategori - MVC</p>
    </div>

    <div class="crud-content">
        <div class="top-menu">
            <div>
                <a class="btn" href="<?= e(BASE_URL . '/dashboard/index.php') ?>">
                    Dashboard
                </a>
                <a class="btn" href="<?= e(BASEURL . '/index.php?url=kategori/add') ?>">
                    Tambah Kategori
                </a>
            </div>
        </div>

        <table>
            <tr>
                <th>No</th>
                <th>ID Kategori</th>
                <th>Nama Kategori</th>
                <th>Aksi</th>
            </tr>
            <?php foreach ($items as $index => $item): ?>
                <tr>
                    <td><?= $index + 1 ?></td>
                    <td><?= (int) $item['id_kategori'] ?></td>
                    <td><?= e($item['nama_kategori']) ?></td>
                    <td>
                        <a class="edit"
                           href="<?= e(BASEURL . '/index.php?url=kategori/edit/' . (int) $item['id_kategori']) ?>">
                            Edit
                        </a>
                        <form method="post"
                              action="<?= e(BASEURL . '/index.php?url=kategori/delete/' . (int) $item['id_kategori']) ?>"
                              onsubmit="return confirm('Yakin ingin menghapus kategori ini?');">
                            <input type="hidden" name="_token" value="<?= e($csrfToken) ?>">
                            <button class="hapus" type="submit">Hapus</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
            <?php if (!$items): ?>
                <tr><td colspan="4">Belum ada data kategori.</td></tr>
            <?php endif; ?>
        </table>
    </div>

    <div class="crud-footer">
        Pergi Bareng, Pulang Bareng atau Hilang Bareng
    </div>
</div>
</body>
</html>