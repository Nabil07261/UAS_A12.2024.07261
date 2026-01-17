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
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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

        <form action="SimpanRegister.php" method="POST" enctype="multipart/form-data" class="formulir"
            style="margin: 0 auto;" id="formRegister">
            <div class="kolom-input">
                <label>Foto:</label>
                <input type="file" name="foto" accept="image/*" class="input-file" required>
            </div>
            <div class="kolom-input">
                <label>Nama Lengkap:</label>
                <input type="text" name="nama" class="input-teks" minlength="3" required
                    title="Nama minimal 3 karakter">
            </div>
            <div class="kolom-input">
                <label>Username:</label>
                <input type="text" name="username" class="input-teks" pattern="[a-zA-Z0-9]{4,20}" required
                    title="Username 4-20 karakter, huruf dan angka saja">
            </div>
            <div class="kolom-input">
                <label>Password:</label>
                <input type="password" name="password" id="password" class="input-password" minlength="6" required
                    title="Password minimal 6 karakter">
            </div>
            <div class="kolom-input">
                <label>Konfirmasi Password:</label>
                <input type="password" name="confirm_password" id="confirm_password" class="input-password"
                    minlength="6" required title="Konfirmasi password harus sama">
            </div>
            <div class="kolom-input">
                <button type="submit" class="tombol tombol-utama">Register</button>
            </div>
        </form>

        <p class="teks-tengah margin-atas">Sudah punya akun? <a href="index.php" class="tautan">Login disini</a></p>
    </div>

    <script>
        document.getElementById('formRegister').addEventListener('submit', function (e) {
            var password = document.getElementById('password').value;
            var confirm = document.getElementById('confirm_password').value;
            if (password !== confirm) {
                alert('Password dan Konfirmasi Password harus sama!');
                e.preventDefault();
            }
        });
    </script>
</body>

</html>