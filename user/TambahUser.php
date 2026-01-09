<?php
include "../koneksi.php";
?>
<!DOCTYPE html>
<html>

<head>
    <title>Tambah User</title>
    <link rel="stylesheet" href="../css/style.css">
</head>

<body>
    <div class="wadah">
        <h1 class="judul">Tambah User Baru</h1>

        <div class="navigasi">
            <a href="TampilUser.php" class="tautan-tombol">Kembali</a>
        </div>

        <form action="SimpanUser.php" method="POST" enctype="multipart/form-data" class="formulir">
            <div class="kolom-input">
                <label>Foto:</label>
                <input type="file" name="foto" accept="image/*" class="input-file" required>
            </div>
            <div class="kolom-input">
                <label>Username:</label>
                <input type="text" name="username" class="input-teks" required>
            </div>
            <div class="kolom-input">
                <label>Nama Lengkap:</label>
                <input type="text" name="nama" class="input-teks" required>
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
                <button type="submit" class="tombol tombol-utama">Simpan</button>
            </div>
        </form>
    </div>
</body>

</html>