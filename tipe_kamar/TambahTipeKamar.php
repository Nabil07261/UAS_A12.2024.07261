<?php
include "../koneksi.php";
?>
<!DOCTYPE html>
<html>

<head>
    <title>Tambah Tipe Kamar</title>
    <link rel="stylesheet" href="../css/style.css">
</head>

<body>
    <div class="wadah">
        <h1 class="judul">Tambah Tipe Kamar Baru</h1>

        <div class="navigasi">
            <a href="TampilTipeKamar.php" class="tautan-tombol">Kembali</a>
        </div>

        <form action="SimpanTipeKamar.php" method="POST" enctype="multipart/form-data" class="formulir">
            <div class="kolom-input">
                <label>Foto Kamar:</label>
                <input type="file" name="foto" accept="image/*" class="input-file" required>
            </div>
            <div class="kolom-input">
                <label>Tipe Kamar:</label>
                <input type="text" name="tipe" class="input-teks" required>
            </div>
            <div class="kolom-input">
                <label>Harga per Malam:</label>
                <input type="number" name="harga_per_mlm" class="input-angka" required>
            </div>
            <div class="kolom-input">
                <label>Max Orang:</label>
                <input type="number" name="max_orang" class="input-angka" required>
            </div>
            <div class="kolom-input">
                <button type="submit" class="tombol tombol-utama">Simpan</button>
            </div>
        </form>
    </div>
</body>

</html>