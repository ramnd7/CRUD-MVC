<?php
include '../koneksi/koneksi.php';
include '../login/middleware.php';

if (isset($_POST['simpan'])) {

    $nama_gear   = $_POST['nama_gear'];
    $merek       = $_POST['merek'];
    $id_kategori = $_POST['id_kategori'];
    $harga_sewa  = $_POST['harga_sewa'];
    $stok        = $_POST['stok'];
    $status      = $_POST['status'];
    $deskripsi   = $_POST['deskripsi'];

    // Upload Foto
    $nama_file   = $_FILES['foto']['name'];
    $ukuran_file = $_FILES['foto']['size'];
    $error       = $_FILES['foto']['error'];
    $tmp_name    = $_FILES['foto']['tmp_name'];

    if ($error === 4) {
        echo "<script>
                alert('Pilih foto gear terlebih dahulu!');
                window.history.back();
              </script>";
        exit();
    }

    // Validasi ekstensi
    $ekstensi_valid = ['jpg','jpeg','png'];

    $ekstensi_file = strtolower(pathinfo($nama_file, PATHINFO_EXTENSION));

    if (!in_array($ekstensi_file,$ekstensi_valid)) {

        echo "<script>
                alert('Format foto harus JPG, JPEG atau PNG!');
                window.history.back();
              </script>";
        exit();
    }

    // Maksimal 2MB

    if ($ukuran_file > 2000000) {

        echo "<script>
                alert('Ukuran foto maksimal 2MB!');
                window.history.back();
              </script>";
        exit();
    }

    // Folder upload

    if (!is_dir('uploads')) {

        mkdir('uploads',0755,true);

    }

    // Nama file baru

    $nama_file_baru = uniqid() . "." . $ekstensi_file;

    $folder_tujuan = "uploads/" . $nama_file_baru;

    if(move_uploaded_file($tmp_name,$folder_tujuan)){

        $query = "INSERT INTO gear
        (nama_gear,merek,id_kategori,harga_sewa,stok,status,foto,deskripsi)

        VALUES

        ('$nama_gear',
        '$merek',
        '$id_kategori',
        '$harga_sewa',
        '$stok',
        '$status',
        '$nama_file_baru',
        '$deskripsi')";

        if(mysqli_query($koneksi,$query)){

            header("Location:index.php");
            exit();

        }else{

            echo "Gagal : ".mysqli_error($koneksi);

        }

    }else{

        echo "<script>
        alert('Upload foto gagal!');
        window.history.back();
        </script>";

    }

}else{

    header("Location:index.php");
    exit();

}
?>