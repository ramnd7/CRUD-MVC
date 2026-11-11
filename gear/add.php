<?php
include '../koneksi/koneksi.php';
include '../login/middleware.php';

// Mengambil data kategori
$kategori = mysqli_query($koneksi, "SELECT * FROM kategori ORDER BY nama_kategori ASC");
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Tambah Gear</title>
    <link rel="stylesheet" href="../css/crud.css">
</head>
<body>

<div class="crud-box">

    <div class="crud-header">
        <h1>🏕️ Pesona Rental Gear</h1>
        <p>Tambah Data Gear</p>
    </div>

    <div class="crud-content">

        <form method="POST" enctype="multipart/form-data" class="form-crud">

            <label>Nama Gear</label>
            <input type="text" name="nama_gear" required>

            <label>Merek</label>
            <input type="text" name="merek" required>

            <label>Kategori</label>
            <select name="id_kategori" required>

                <option value="">-- Pilih Kategori --</option>

                <?php
                $kategori = mysqli_query($koneksi,"SELECT * FROM kategori");

                while($row=mysqli_fetch_assoc($kategori)){
                ?>

                <option value="<?= $row['id_kategori']; ?>">
                               <?= $row['nama_kategori']; ?>
                </option>

                <?php } ?>

            </select>

            <label>Harga Sewa / Hari</label>
            <input type="number" name="harga_sewa" required>

            <label>Stok</label>
            <input type="number" name="stok" required>

            <label>Status</label>

            <select name="status">

                <option value="Tersedia">Tersedia</option>
                <option value="Disewa">Disewa</option>
                <option value="Maintenance">Maintenance</option>

            </select>

            <label>Deskripsi</label>

            <textarea
            name="deskripsi"
            rows="4"></textarea>

            <label>Foto Gear</label>

            <input
            type="file"
            name="foto"
            accept=".jpg,.jpeg,.png"
            required>

            <br><br>

            <button class="btn-simpan" type="submit" name="simpan">
                Simpan
            </button>

            <a class="btn-kembali" href="index.php">
                Kembali
            </a>

        </form>

    </div>

    <div class="crud-footer">
        Sistem Rental Outdoor Gear
    </div>

</div>

</body>
</html>