<?php 
$koneksi = mysqli_connect("localhost", "root", "", "db_rental_gear"); 

if (!$koneksi) 
{     
die("Koneksi gagal: " . mysqli_connect_error()); 
}

//method search
function cari($keyword)
{
    global $koneksi;

    $query = "SELECT gear.*, kategori.nama_kategori
              FROM gear
              JOIN kategori
              ON gear.id_kategori = kategori.id_kategori
              WHERE
              nama_gear LIKE '%$keyword%' OR
              merek LIKE '%$keyword%' OR
              nama_kategori LIKE '%$keyword%' OR
              status LIKE '%$keyword%'
              ORDER BY id_gear ASC";

    return mysqli_query($koneksi, $query);
}

?> 