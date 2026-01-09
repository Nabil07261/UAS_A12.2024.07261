<?php
session_start();
include 'koneksi.php';

if (isset($_SESSION['username'])) {
    header("location:menu.php");
    exit;
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Login - Hotel System</title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <div class="wadah">
        <div class="kotak-header">
            <h1 class="judul">LOGIN</h1>
            <p class="judul-kecil">Sistem Manajemen Hotel</p>
        </div>

        <form method="post" class="formulir" style="margin: 0 auto;">
            <div class="kolom-input">
                <label for="username">Username :</label>
                <input type="text" name="username" id="username" class="input-teks" required autofocus>
            </div>
            <div class="kolom-input">
                <label for="password">Password :</label>
                <input type="password" name="password" id="password" class="input-password" required>
            </div>
            <div class="kolom-input">
                <button type="submit" name="login" class="tombol tombol-utama">Login</button>
            </div>
        </form>

        <p class="teks-tengah margin-atas">
            <a href="register.php" class="tautan">Register</a>
        </p>

        <?php
        if (isset($_POST['login'])) {
            $username = mysqli_real_escape_string($koneksi, $_POST['username']);
            $password = $_POST['password'];

            $result = mysqli_query($koneksi, "SELECT * FROM users WHERE username = '$username' LIMIT 1");
            $user = mysqli_fetch_assoc($result);

            if ($user) {
                if (password_verify($password, $user['password'])) {
                    $_SESSION['user_id'] = $user['id'];
                    $_SESSION['username'] = $user['username'];
                    $_SESSION['nama'] = $user['nama'];
                    header("location:menu.php");
                    exit;
                } else {
                    echo "<p class='pesan-error teks-tengah'>Password salah!</p>";
                }
            } else {
                echo "<p class='pesan-error teks-tengah'>Username tidak ditemukan!</p>";
            }
        }
        ?>
    </div>
</body>

</html>