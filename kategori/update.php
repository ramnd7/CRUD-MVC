<?php
include '../koneksi/koneksi.php';
include '../login/middleware.php';

if (isset($_POST['update'])) {

    $id = $_POST['id_kategori'];
    $nama_kategori = $_POST['nama_kategori'];

    $query = "UPDATE kategori
              SET nama_kategori = '$nama_kategori'
              WHERE id_kategori = '$id'";

    if (mysqli_query($koneksi, $query)) {
        header("Location: index.php");
        exit();
    } else {
        echo "Gagal mengubah data: " . mysqli_error($koneksi);
    }

} else {

    header("Location: index.php");
    exit();

}
?>