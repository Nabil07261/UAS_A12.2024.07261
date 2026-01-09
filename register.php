<?php
session_start();
include 'koneksi.php';

$error = '';
$success = '';

if (isset($_SESSION['register_error'])) {
    $error = $_SESSION['register_error'];
    unset($_SESSION['register_error']);
}
if (isset($_SESSION['register_success'])) {
    $success = $_SESSION['register_success'];
    unset($_SESSION['register_success']);
}

if (isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit;
}
?>
<!DOCTYPE html>
<html>

<head>
    <title>Register - Hotel Room Rental System</title>
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <div class="wadah">
        <div class="kotak-header">
            <h1 class="judul">Register</h1>
            <p class="judul-kecil">Hotel Room Rental System</p>
        </div>

        <?php if ($error): ?>
            <p class="pesan-error"><?= $error ?></p>
        <?php endif; ?>

        <?php if ($success): ?>
            <p class="pesan-sukses"><?= $success ?></p>
        <?php endif; ?>

        <form action="SimpanRegister.php" method="POST" enctype="multipart/form-data" class="formulir" style="margin: 0 auto;">
            <div class="kolom-input">
                <label>Foto:</label>
                <input type="file" name="foto" accept="image/*" class="input-file" required>
            </div>
            <div class="kolom-input">
                <label>Nama Lengkap:</label>
                <input type="text" name="nama" class="input-teks" required>
            </div>
            <div class="kolom-input">
                <label>Username:</label>
                <input type="text" name="username" class="input-teks" required>
            </div>
            <div class="kolom-input">
                <label>Password:</label>
                <input type="password" name="password" class="input-password" required>
            </div>
            <div class="kolom-input">
                <label>Konfirmasi Password:</label>
                <input type="password" name="confirm_password" class="input-password" required>
            </div>
            <div class="kolom-input">
                <button type="submit" class="tombol tombol-utama">Register</button>
            </div>
        </form>

        <p class="teks-tengah margin-atas">Sudah punya akun? <a href="index.php" class="tautan">Login disini</a></p>
    </div>
</body>

</html>