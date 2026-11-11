<?php
include '../koneksi/koneksi.php';
include '../login/middleware.php';

if (isset($_POST['simpan'])) {

    $nama_kategori = $_POST['nama_kategori'];

    $query = "INSERT INTO kategori (nama_kategori)
              VALUES ('$nama_kategori')";

    if (mysqli_query($koneksi, $query)) {

        header("Location: index.php");
        exit();

    } else {

        echo "Gagal menyimpan data : " . mysqli_error($koneksi);

    }

} else {

    header("Location: index.php");
    exit();

}
?>