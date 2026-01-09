<?php
include "../koneksi.php";

$tipe_kamar = mysqli_query($koneksi, "SELECT * FROM tipe_kamar ORDER BY tipe");
?>
<!DOCTYPE html>
<html>

<head>
    <title>Tambah Kamar</title>
    <link rel="stylesheet" href="../css/style.css">
</head>

<body>
    <div class="wadah">
        <h1 class="judul">Tambah Kamar Baru</h1>

        <div class="navigasi">
            <a href="TampilKamar.php" class="tautan-tombol">Kembali</a>
        </div>

        <form action="SimpanKamar.php" method="POST" class="formulir">
            <div class="kolom-input">
                <label>No Kamar:</label>
                <input type="text" name="no_kamar" class="input-teks" required>
            </div>
            <div class="kolom-input">
                <label>Tipe Kamar:</label>
                <select name="id_kamar" class="pilihan" required>
                    <option value="">-- Pilih Tipe --</option>
                    <?php while ($tipe = mysqli_fetch_assoc($tipe_kamar)): ?>
                        <option value="<?= $tipe['id_kamar'] ?>">
                            <?= htmlspecialchars($tipe['tipe']) ?>
                        </option>
                    <?php endwhile; ?>
                </select>
            </div>
            <div class="kolom-input">
                <label>Lantai:</label>
                <input type="number" name="lantai" class="input-angka" required>
            </div>
            <div class="kolom-input">
                <button type="submit" class="tombol tombol-utama">Simpan</button>
            </div>
        </form>
    </div>
</body>

</html>