<?php
include '../koneksi/koneksi.php';
include '../login/middleware.php';

if (isset($_POST['update'])) {

    // Mengambil data dari form
    $id_gear      = $_POST['id_gear'];
    $nama_gear    = $_POST['nama_gear'];
    $merek        = $_POST['merek'];
    $id_kategori  = $_POST['id_kategori'];
    $harga_sewa   = $_POST['harga_sewa'];
    $stok         = $_POST['stok'];
    $status       = $_POST['status'];
    $deskripsi    = $_POST['deskripsi'];

    // Foto lama
    $foto_lama = $_POST['foto_lama'];

    // Default memakai foto lama
    $foto_final = $foto_lama;

    // Data upload foto baru
    $nama_file   = $_FILES['foto']['name'];
    $ukuran_file = $_FILES['foto']['size'];
    $error       = $_FILES['foto']['error'];
    $tmp_name    = $_FILES['foto']['tmp_name'];

    // Jika admin upload foto baru
    if ($error !== 4) {

        // Validasi ekstensi
        $ekstensi_valid = ['jpg', 'jpeg', 'png'];
        $ekstensi_file = strtolower(pathinfo($nama_file, PATHINFO_EXTENSION));

        if (!in_array($ekstensi_file, $ekstensi_valid)) {

            echo "<script>
                    alert('Format foto harus JPG, JPEG, atau PNG!');
                    window.history.back();
                  </script>";
            exit();
        }

        // Validasi ukuran maksimal 2MB
        if ($ukuran_file > 2000000) {

            echo "<script>
                    alert('Ukuran foto maksimal 2MB!');
                    window.history.back();
                  </script>";
            exit();
        }

        // Nama file baru
        $nama_file_baru = uniqid() . "." . $ekstensi_file;

        $folder_tujuan = "uploads/" . $nama_file_baru;

        if (move_uploaded_file($tmp_name, $folder_tujuan)) {

            // Hapus foto lama
            if (!empty($foto_lama) && file_exists("uploads/" . $foto_lama)) {

                unlink("uploads/" . $foto_lama);

            }

            // Gunakan foto baru
            $foto_final = $nama_file_baru;

        } else {

            echo "<script>
                    alert('Upload foto gagal!');
                    window.history.back();
                  </script>";
            exit();
        }

    }

    // Update database
    $query = "UPDATE gear SET

                nama_gear='$nama_gear',
                merek='$merek',
                id_kategori='$id_kategori',
                harga_sewa='$harga_sewa',
                stok='$stok',
                status='$status',
                foto='$foto_final',
                deskripsi='$deskripsi'

              WHERE id_gear='$id_gear'";

    if (mysqli_query($koneksi, $query)) {

        header("Location: index.php");
        exit();

    } else {

        echo "Gagal mengubah data : " . mysqli_error($koneksi);

    }

} else {

    header("Location: index.php");
    exit();

}
?>