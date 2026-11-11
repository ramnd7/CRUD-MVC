<?php
include '../koneksi/koneksi.php';
include '../login/middleware.php';

// Menampilkan seluruh data gear beserta nama kategorinya
// Jumlah data per halaman
$banyakData = 4;

// Hitung total data
$totalData = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM gear"));

// Jumlah halaman
$jumlahHalaman = ceil($totalData / $banyakData);

// Halaman aktif
$halamanAktif = (isset($_GET['halaman'])) ? $_GET['halaman'] : 1;

// Awal data
$awalData = ($banyakData * $halamanAktif) - $banyakData;



// Query default
$query = mysqli_query($koneksi,"
SELECT gear.*, kategori.nama_kategori
FROM gear
JOIN kategori
ON gear.id_kategori = kategori.id_kategori
ORDER BY gear.id_gear ASC
LIMIT $awalData,$banyakData
");


// Jika mencari
if(isset($_POST['cari'])){

    $query = cari($_POST['keyword']);

}
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../css/crud.css">
    <title>Kelola Gear</title>
</head>

<body>

<div class="crud-box">

    <div class="crud-header">
        <h1>Pesona Outdoor</h1>
        <p>Kelola Data Gear</p>
    </div>

    <div class="crud-content">

        <div class="top-menu">

            <div>
                <a class="btn" href="../dashboard/index.php">
                    Dashboard
                </a>

                <a class="btn" href="add.php">
                    Tambah Gear
                </a>
            </div>

            <form method="POST" class="search">

                <input
                type="text"
                name="keyword"
                placeholder="Cari Gear..."
                autocomplete="off">

                <button
                type="submit"
                name="cari">

                Cari

                </button>

            </form>

        </div>

        

        <table>

        <tr>
            <th>No</th>
            <th>Foto</th>
            <th>Nama Gear</th>
            <th>Merek</th>
            <th>Kategori</th>
            <th>Harga / Hari</th>
            <th>Stok</th>
            <th>Status</th>
            <th>Deskripsi</th>
            <th>Aksi</th>
        </tr>

        <?php

        $no = $awalData + 1;

        while($row = mysqli_fetch_assoc($query)){

        ?>

        <tr>

        <td><?= $no++; ?></td>

        <td>

        <?php if(!empty($row['foto'])){ ?>

        <img src="uploads/<?= $row['foto']; ?>" width="80">

        <?php }else{ ?>

        Tidak Ada Foto

        <?php } ?>

        </td>

        <td><?= $row['nama_gear']; ?></td>

        <td><?= $row['merek']; ?></td>

        <td><?= $row['nama_kategori']; ?></td>

        <td>Rp <?= number_format($row['harga_sewa'],0,',','.'); ?></td>

        <td><?= $row['stok']; ?></td>

        <td><?= $row['status']; ?></td>

        <td><?= $row['deskripsi']; ?></td>

        <td>

        <a class="edit" href="edit.php?id=<?= $row['id_gear']; ?>">
            Edit
        </a>

        <a class="hapus"
        href="hapus.php?id=<?= $row['id_gear']; ?>"
        onclick="return confirm('Yakin ingin menghapus gear ini?');">

        Hapus

        </a>

        </td>

        </tr>

        <?php } ?>

        </table>

        <div class="pagination">

        <?php for($i=1;$i<=$jumlahHalaman;$i++) : ?>

            <?php if($i==$halamanAktif): ?>

                <span class="aktif"><?= $i; ?></span>

            <?php else: ?>

                <a href="?halaman=<?= $i; ?>">
                    <?= $i; ?>
                </a>

            <?php endif; ?>

        <?php endfor; ?>

        </div>

    </div>

    <div class="crud-footer">

        Pergi Bareng, Pulang Bareng atau Hilang Bareng

    </div>

</div>

</body>
</html>