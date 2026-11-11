<?php session_start();

if (!isset($_SESSION['login'])) {
     echo "<script>
            alert('Silakan Login Terlebih Dahulu.');
            window.location.href = '../login/login.php';
          </script>";
    
    exit();
} ?>