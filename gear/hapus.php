<?php
include '../koneksi/koneksi.php';
include '../login/middleware.php';

// Cek apakah ada ID yang dikirim
if (isset($_GET['id'])) {

    $id_gear = $_GET['id'];

    // Mengambil data gear berdasarkan ID
    $query = mysqli_query($koneksi, "SELECT * FROM gear WHERE id_gear='$id_gear'");

    $data = mysqli_fetch_assoc($query);

    // Jika data tidak ditemukan
    if (!$data) {

        die("Data gear tidak ditemukan.");

    }

    // Hapus file foto jika ada
    if (!empty($data['foto']) && file_exists("uploads/" . $data['foto'])) {

        unlink("uploads/" . $data['foto']);

    }

    // Hapus data dari database
    $hapus = mysqli_query($koneksi, "DELETE FROM gear WHERE id_gear='$id_gear'");

    if ($hapus) {

        header("Location: index.php");
        exit();

    } else {

        echo "Gagal menghapus data : " . mysqli_error($koneksi);

    }

} else {

    header("Location: index.php");
    exit();

}
?>