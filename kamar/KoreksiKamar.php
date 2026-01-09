<?php
include "../koneksi.php";

$id = mysqli_real_escape_string($koneksi, $_GET['id']);

$tipe_kamar = mysqli_query($koneksi, "SELECT * FROM tipe_kamar ORDER BY tipe");

$result = mysqli_query($koneksi, "SELECT * FROM bedroom WHERE no_kamar = '$id'");
$data = mysqli_fetch_assoc($result);
?>
<!DOCTYPE html>
<html>

<head>
    <title>Edit Kamar</title>
    <link rel="stylesheet" href="../css/style.css">
</head>

<body>
    <div class="wadah">
        <h1 class="judul">Edit Kamar</h1>

        <div class="navigasi">
            <a href="TampilKamar.php" class="tautan-tombol">Kembali</a>
        </div>

        <form action="SimpanKoreksiKamar.php" method="POST" class="formulir">
            <input type="hidden" name="id" value="<?= htmlspecialchars($data['no_kamar']) ?>">
            <div class="kolom-input">
                <label>No Kamar:</label>
                <p><strong><?= htmlspecialchars($data['no_kamar']) ?></strong></p>
            </div>
            <div class="kolom-input">
                <label>Tipe Kamar:</label>
                <select name="id_kamar" class="pilihan" required>
                    <?php while ($tipe = mysqli_fetch_assoc($tipe_kamar)): ?>
                        <option value="<?= $tipe['id_kamar'] ?>" <?= $tipe['id_kamar'] == $data['id_kamar'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($tipe['tipe']) ?>
                        </option>
                    <?php endwhile; ?>
                </select>
            </div>
            <div class="kolom-input">
                <label>Lantai:</label>
                <input type="number" name="lantai" value="<?= $data['lantai'] ?>" class="input-angka" required>
            </div>
            <div class="kolom-input">
                <button type="submit" class="tombol tombol-utama">Update</button>
            </div>
        </form>
    </div>
</body>

</html>