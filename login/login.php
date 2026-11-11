<?php session_start();
include '../koneksi/koneksi.php';

if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $query = mysqli_query($koneksi, "SELECT * FROM users WHERE username='$username'");
    $user = mysqli_fetch_assoc($query);
    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['login'] = true;
        $_SESSION['username'] = $username;
        header("Location: ../dashboard/index.php");
        exit();
    } else {
        echo "<div style='width:350px; margin:20px auto; padding:10px; 
                border:1px solid red; background:#ffecec; 
                text-align:center; color:red; border-radius:5px;'>
            <b>Username atau Password Salah</b>
          </div>";;
    }
} ?>
</head>
<link rel="stylesheet" href="../css/login.css">
<body>
<div class="login-box">

    <div class="login-header">

        <h2>Pesona Outdoor</h2>

        <p>Silakan login untuk melanjutkan</p>

    </div>

    <div class="login-content">

        <form method="POST">

            <label>Username</label>

            <input
            type="text"
            name="username"
            placeholder="Masukkan Username"
            required>

            <label>Password</label>

            <input
            type="password"
            name="password"
            placeholder="Masukkan Password"
            required>

            <button
            type="submit"
            name="login">

            Login

            </button>

        </form>

        <div class="footer">

            Sistem Rental Outdoor Gear

        </div>

    </div>

</div>


</body>
</html>