<?php
include '../koneksi/koneksi.php';
include '../login/middleware.php';
$username = $_SESSION['username'];

// Menghitung total kategori
$totalKategori = mysqli_query($koneksi, "SELECT COUNT(*) AS total FROM kategori");
$dataKategori = mysqli_fetch_assoc($totalKategori);

// Menghitung total gear
$totalGear = mysqli_query($koneksi, "SELECT COUNT(*) AS total FROM gear");
$dataGear = mysqli_fetch_assoc($totalGear);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Rental Gear</title>
    <link rel="stylesheet" href="../css/dashboard.css">
</head>
<body>

<div class="dashboard-box">

    <div class="dashboard-header">

        <h1>Pesona Outdoor</h1>
        <p>Management System</p>

    </div>

    <div class="dashboard-content">

        <h2>Selamat Datang, <?= $_SESSION['username']; ?> </h2>

        <p class="subjudul">Dashboard Administrator</p>

        <div class="card">

            <p><strong>Total Kategori Gear</strong></p>
            <h2><?= $dataKategori['total']; ?></h2>

            <hr>

            <p><strong>Total Gear</strong></p>
            <h2><?= $dataGear['total']; ?></h2>

        </div>

        <div class="menu">

            <a class="btn kategori" href="../kategori/index.php">
                Kelola Kategori
            </a>

            <a class="btn kategori" href="../public/index.php?url=kategori">
                Kelola Kategori (MVC)
            </a>

            <a class="btn gear" href="../gear/index.php">
                Kelola Gear
            </a>

            <a class="btn gear" href="../public/index.php?url=gear">
                Kelola Gear (MVC)
            </a>

            <a class="btn logout" href="../login/logout.php">
                Logout
            </a>

        </div>

    </div>

    <div class="dashboard-footer">

        Pergi Bareng, Pulang Bareng atau Hilang Bareng

    </div>

</div>

</body>
</html>