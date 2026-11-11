<?php
include '../koneksi/koneksi.php';
include '../login/middleware.php';

// Ambil ID kategori dari URL
$id = $_GET['id'];

// Hapus data kategori
$query = "DELETE FROM kategori WHERE id_kategori = '$id'";

if (mysqli_query($koneksi, $query)) {
    header("Location: index.php");
    exit();
} else {
    echo "Gagal menghapus data: " . mysqli_error($koneksi);
}
?>