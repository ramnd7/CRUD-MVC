<?php
include '../koneksi/koneksi.php';
include '../login/middleware.php';

if(isset($_POST['simpan'])){

    $nama_kategori = $_POST['nama_kategori'];

    $query = mysqli_query($koneksi,"INSERT INTO kategori(nama_kategori)
                                   VALUES('$nama_kategori')");

    if($query){
        header("Location:index.php");
        exit();
    }else{
        echo "Gagal menambah data : ".mysqli_error($koneksi);
    }

}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Tambah Kategori</title>
    <link rel="stylesheet" href="../css/crud.css">
</head>
<body>

<div class="crud-box">

    <div class="crud-header">

        <h1>🏕️ Pesona Rental Gear</h1>
        <p>Tambah Kategori</p>

    </div>

    <div class="crud-content">

        <form method="POST" class="form-crud">

            <label>Nama Kategori</label>

            <input
            type="text"
            name="nama_kategori"
            placeholder="Contoh : Carrier"
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