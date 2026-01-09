<?php
require_once 'auth.php';
?>
<!DOCTYPE html>
<html>

<head>
    <title>Hotel Room Rental System</title>
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <div class="wadah">
        <div class="kotak-header">
            <h1 class="judul">Sistem Manajemen Hotel</h1>
            <p>Selamat datang, <strong><?= htmlspecialchars($_SESSION['nama']) ?></strong>! |
                <a href="logout.php" class="tautan">Logout</a>
            </p>
        </div>

        <h2 class="judul-kecil">Menu Utama</h2>

        <ul class="daftar-menu">
            <li><a href="transaksi_baru.php"><strong>Transaksi Baru</strong></a></li>
            <li><a href="tipe_kamar/TampilTipeKamar.php">Kelola Tipe Kamar</a></li>
            <li><a href="kamar/TampilKamar.php">Kelola Kamar</a></li>
            <li><a href="penyewa/TampilPenyewa.php">Kelola Penyewa</a></li>
            <li><a href="transaksi/TampilTransaksi.php">Kelola Transaksi Sewa</a></li>
            <li><a href="user/TampilUser.php">Kelola User</a></li>
        </ul>
    </div>
</body>

</html>