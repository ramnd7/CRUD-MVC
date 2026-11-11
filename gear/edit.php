<?php
include '../koneksi/koneksi.php';
include '../login/middleware.php';

// Mengambil ID Gear dari URL
$id = $_GET['id'];

// Mengambil data gear berdasarkan ID beserta kategorinya
$query = mysqli_query($koneksi, "
SELECT * FROM gear
WHERE id_gear = '$id'
");

$data = mysqli_fetch_assoc($query);

// Jika data tidak ditemukan
if (mysqli_num_rows($query) < 1) {
    die("Data gear tidak ditemukan.");
}

// Mengambil seluruh kategori
$kategori = mysqli_query($koneksi, "SELECT * FROM kategori ORDER BY nama_kategori ASC");
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Edit Gear</title>
    <link rel="stylesheet" href="../css/crud.css">
</head>
<body>

<div class="crud-box">

    <div class="crud-header">
        <h1>🏕️ Pesona Rental Gear</h1>
        <p>Edit Data Gear</p>
    </div>

    <div class="crud-content">

<form action="update.php"
method="POST"
enctype="multipart/form-data"
class="form-crud">

<input
type="hidden"
name="id_gear"
value="<?= $data['id_gear']; ?>">

<label>Nama Gear</label>

<input
type="text"
name="nama_gear"
value="<?= $data['nama_gear']; ?>"
required>

<label>Merek</label>

<input
type="text"
name="merek"
value="<?= $data['merek']; ?>"
required>

<label>Kategori</label>

<select name="id_kategori">

<?php

$kategori=mysqli_query($koneksi,"SELECT * FROM kategori");

while($row=mysqli_fetch_assoc($kategori)){

?>

<option
value="<?= $row['id_kategori']; ?>"

<?= ($row['id_kategori']==$data['id_kategori'])?'selected':''; ?>

>

<?= $row['nama_kategori']; ?>

</option>

<?php } ?>

</select>

<label>Harga Sewa / Hari</label>

<input
type="number"
name="harga_sewa"
value="<?= $data['harga_sewa']; ?>"
required>

<label>Stok</label>

<input
type="number"
name="stok"
value="<?= $data['stok']; ?>"
required>

<label>Status</label>

<select name="status">

<option
value="Tersedia"
<?= ($data['status']=="Tersedia")?'selected':''; ?>>
Tersedia
</option>

<option
value="Disewa"
<?= ($data['status']=="Disewa")?'selected':''; ?>>
Disewa
</option>

<option
value="Maintenance"
<?= ($data['status']=="Maintenance")?'selected':''; ?>>
Maintenance
</option>

</select>

<label>Deskripsi</label>

<textarea
name="deskripsi"
rows="4"><?= $data['deskripsi']; ?></textarea>

<label>Foto Saat Ini</label>

<?php if($data['foto']){ ?>

<img
src="uploads/<?= $data['foto']; ?>"
width="180">

<?php } ?>

<br><br>

<label>Ganti Foto (Opsional)</label>

<input
type="file"
name="foto">

<br><br>

<button
class="btn-simpan"
type="submit"
name="update">

Simpan Perubahan

</button>

<a
class="btn-kembali"
href="index.php">

Batal

</a>

</form>

</div>

<div class="crud-footer">

Sistem Rental Outdoor Gear

</div>

</div>

</body>
</html>