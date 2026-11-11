<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Kelola Gear</title>
    <link rel="stylesheet" href="<?= e(BASE_URL . '/css/crud.css') ?>">
</head>
<body>
<div class="crud-box">
    <div class="crud-header">
        <h1>Pesona Outdoor</h1>
        <p>Kelola Data Gear — MVC</p>
    </div>
    <div class="crud-content">
        <div class="top-menu">
            <div>
                <a class="btn" href="<?= e(BASE_URL . '/dashboard/index.php') ?>">Dashboard</a>
                <a class="btn" href="<?= e(BASEURL . '/index.php?url=gear/add') ?>">Tambah Gear</a>
            </div>
            <form method="get" action="<?= e(BASEURL . '/index.php') ?>" class="search">
                <input type="hidden" name="url" value="gear">
                <input type="text" name="q" value="<?= e($search) ?>"
                       placeholder="Cari Gear..." autocomplete="off">
                <button type="submit">Cari</button>
            </form>
        </div>
        <table>
            <tr>
                <th>No</th><th>Foto</th><th>Nama Gear</th><th>Merek</th>
                <th>Kategori</th><th>Harga / Hari</th><th>Stok</th>
                <th>Status</th><th>Deskripsi</th><th>Aksi</th>
            </tr>
            <?php foreach ($items as $index => $item): ?>
                <tr>
                    <td><?= ($page - 1) * 4 + $index + 1 ?></td>
                    <td>
                        <?php if ($item['foto'] !== ''): ?>
                            <img src="<?= e(BASE_URL . '/gear/uploads/' . rawurlencode($item['foto'])) ?>"
                                 alt="<?= e($item['nama_gear']) ?>" width="80">
                        <?php else: ?>
                            Tidak Ada Foto
                        <?php endif; ?>
                    </td>
                    <td><?= e($item['nama_gear']) ?></td>
                    <td><?= e($item['merek']) ?></td>
                    <td><?= e($item['nama_kategori']) ?></td>
                    <td>Rp <?= e(number_format((float) $item['harga_sewa'], 0, ',', '.')) ?></td>
                    <td><?= e($item['stok']) ?></td>
                    <td><?= e($item['status']) ?></td>
                    <td><?= nl2br(e($item['deskripsi'])) ?></td>
                    <td>
                        <a class="edit"
                           href="<?= e(BASEURL . '/index.php?url=gear/edit/' . (int) $item['id_gear']) ?>">
                            Edit
                        </a>
                        <form method="post"
                              action="<?= e(BASEURL . '/index.php?url=gear/delete/' . (int) $item['id_gear']) ?>"
                              onsubmit="return confirm('Yakin ingin menghapus gear ini?');">
                            <input type="hidden" name="_token" value="<?= e($csrfToken) ?>">
                            <button class="hapus" type="submit">Hapus</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
            <?php if (!$items): ?>
                <tr><td colspan="10">Data gear tidak ditemukan.</td></tr>
            <?php endif; ?>
        </table>
        <div class="pagination">
            <?php for ($number = 1; $number <= $pageCount; $number++): ?>
                <?php if ($number === $page): ?>
                    <span class="aktif"><?= $number ?></span>
                <?php else: ?>
                    <a href="<?= e(BASEURL . '/index.php?url=gear&q=' . rawurlencode($search) . '&page=' . $number) ?>">
                        <?= $number ?>
                    </a>
                <?php endif; ?>
            <?php endfor; ?>
        </div>
    </div>
    <div class="crud-footer">Pergi Bareng, Pulang Bareng atau Hilang Bareng</div>
</div>
</body>
</html>
