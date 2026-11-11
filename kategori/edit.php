<?php
include '../koneksi/koneksi.php';
include '../login/middleware.php';

// Ambil ID kategori
$id = $_GET['id'];

// Ambil data kategori
$query = mysqli_query($koneksi, "SELECT * FROM kategori WHERE id_kategori='$id'");
$data = mysqli_fetch_assoc($query);

// Jika data tidak ditemukan
if (mysqli_num_rows($query) < 1) {
    die("Data kategori tidak ditemukan.");
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Kategori</title>
</head>
<body>

<h2>Edit Kategori</h2>

<form action="update.php" method="POST">

    <input type="hidden" name="id_kategori" value="<?= $data['id_kategori']; ?>">

    <table cellpadding="5">

        <tr>
            <td>Nama Kategori</td>
            <td>
                <input
                    type="text"
                    name="nama_kategori"
                    value="<?= $data['nama_kategori']; ?>"
                    required>
            </td>
        </tr>

        <tr>
            <td></td>
            <td>
                <button type="submit" name="update">
                    Simpan Perubahan
                </button>

                <a href="index.php">
                    Batal
                </a>
            </td>
        </tr>

    </table>

</form>

</body>
</html>