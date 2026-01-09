<?php
include "../koneksi.php";
?>
<!DOCTYPE html>
<html>

<head>
    <title>Tambah Penyewa</title>
    <link rel="stylesheet" href="../css/style.css">
</head>

<body>
    <div class="wadah">
        <h1 class="judul">Tambah Penyewa Baru</h1>

        <div class="navigasi">
            <a href="TampilPenyewa.php" class="tautan-tombol">Kembali</a>
        </div>

        <form action="SimpanPenyewa.php" method="POST" class="formulir">
            <div class="kolom-input">
                <label>Nama:</label>
                <input type="text" name="nama" class="input-teks" required>
            </div>
            <div class="kolom-input">
                <label>Alamat:</label>
                <textarea name="alamat" rows="3" class="area-teks"></textarea>
            </div>
            <div class="kolom-input">
                <label>No Telp:</label>
                <input type="text" name="no_telp" class="input-teks">
            </div>
            <div class="kolom-input">
                <label>No Identitas:</label>
                <input type="text" name="no_identitas" class="input-teks" required>
            </div>
            <div class="kolom-input">
                <label>Jenis Identitas:</label>
                <select name="jenis_identitas" class="pilihan" required>
                    <option value="">-- Pilih --</option>
                    <option value="KTP">KTP</option>
                    <option value="SIM">SIM</option>
                    <option value="Paspor">Paspor</option>
                </select>
            </div>
            <div class="kolom-input">
                <button type="submit" class="tombol tombol-utama">Simpan</button>
            </div>
        </form>
    </div>
</body>

</html>