<?php
include "../koneksi.php";

$id = mysqli_real_escape_string($koneksi, $_GET['id']);

$result = mysqli_query($koneksi, "SELECT * FROM penyewa WHERE id_cust = '$id'");
$data = mysqli_fetch_assoc($result);
?>
<!DOCTYPE html>
<html>

<head>
    <title>Edit Penyewa</title>
    <link rel="stylesheet" href="../css/style.css">
</head>

<body>
    <div class="wadah">
        <h1 class="judul">Edit Penyewa</h1>

        <div class="navigasi">
            <a href="TampilPenyewa.php" class="tautan-tombol">Kembali</a>
        </div>

        <form action="SimpanKoreksiPenyewa.php" method="POST" class="formulir">
            <input type="hidden" name="id" value="<?= htmlspecialchars($id) ?>">
            <div class="kolom-input">
                <label>Nama:</label>
                <input type="text" name="nama" value="<?= htmlspecialchars($data['nama']) ?>" class="input-teks"
                    required>
            </div>
            <div class="kolom-input">
                <label>Alamat:</label>
                <textarea name="alamat" rows="3" class="area-teks"><?= htmlspecialchars($data['alamat']) ?></textarea>
            </div>
            <div class="kolom-input">
                <label>No Telp:</label>
                <input type="text" name="no_telp" value="<?= htmlspecialchars($data['no_telp']) ?>" class="input-teks">
            </div>
            <div class="kolom-input">
                <label>No Identitas:</label>
                <input type="text" name="no_identitas" value="<?= htmlspecialchars($data['no_identitas']) ?>"
                    class="input-teks" required>
            </div>
            <div class="kolom-input">
                <label>Jenis Identitas:</label>
                <select name="jenis_identitas" class="pilihan" required>
                    <option value="KTP" <?= $data['jenis_identitas'] == 'KTP' ? 'selected' : '' ?>>KTP</option>
                    <option value="SIM" <?= $data['jenis_identitas'] == 'SIM' ? 'selected' : '' ?>>SIM</option>
                    <option value="Paspor" <?= $data['jenis_identitas'] == 'Paspor' ? 'selected' : '' ?>>Paspor</option>
                </select>
            </div>
            <div class="kolom-input">
                <button type="submit" class="tombol tombol-utama">Update</button>
            </div>
        </form>
    </div>
</body>

</html>