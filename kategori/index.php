<?php
include '../koneksi/koneksi.php';
include '../login/middleware.php';

// Mengambil seluruh data kategori
$query = mysqli_query($koneksi, "SELECT * FROM kategori ORDER BY id_kategori ASC");
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../css/crud.css">
    <title>Kelola Kategori</title>
</head>
<body>

<div class="crud-box">

    <div class="crud-header">

        <h1>Pesona Outdoor</h1>
        <p>Kelola Data Kategori</p>

    </div>

    <div class="crud-content">

        <div class="top-menu">

            <div>

                <a class="btn" href="../dashboard/index.php">
                    Dashboard
                </a>

                <a class="btn" href="add.php">
                    Tambah Kategori
                </a>

            </div>

        </div>

        <table>

            <tr>

                <th>No</th>
                <th>Nama Kategori</th>
                <th>Aksi</th>

            </tr>

            <?php

            $no=1;

            while($row=mysqli_fetch_assoc($query)){

            ?>

            <tr>

                <td><?= $no++; ?></td>

                <td><?= $row['nama_kategori']; ?></td>

                <td>

                    <a class="edit"
                    href="edit.php?id=<?= $row['id_kategori']; ?>">

                    Edit

                    </a>

                    <a
                    class="hapus"
                    href="hapus.php?id=<?= $row['id_kategori']; ?>"
                    onclick="return confirm('Yakin ingin menghapus kategori ini?');">

                    Hapus

                    </a>

                </td>

            </tr>

            <?php } ?>

        </table>

    </div>

    <div class="crud-footer">

        Pergi Bareng, Pulang Bareng atau Hilang Bareng

    </div>

</div>

</body>
</html>