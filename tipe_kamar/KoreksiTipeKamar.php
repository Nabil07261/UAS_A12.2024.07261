<?php
include "../koneksi.php";

$id = $_GET['id'];

$result = mysqli_query($koneksi, "SELECT * FROM tipe_kamar WHERE id_kamar = '$id'");
$data = mysqli_fetch_assoc($result);
?>
<!DOCTYPE html>
<html>

<head>
    <title>Edit Tipe Kamar</title>
    <link rel="stylesheet" href="../css/style.css">
</head>

<body>
    <div class="wadah">
        <h1 class="judul">Edit Tipe Kamar</h1>

        <div class="navigasi">
            <a href="TampilTipeKamar.php" class="tautan-tombol">Kembali</a>
        </div>

        <form action="SimpanKoreksiTipeKamar.php" method="POST" enctype="multipart/form-data" class="formulir">
            <input type="hidden" name="id" value="<?= htmlspecialchars($id) ?>">
            <input type="hidden" name="foto_lama" value="<?= htmlspecialchars($data['foto'] ?? '') ?>">

            <div class="kolom-input">
                <label>Foto Saat Ini:</label><br>
                <?php if (!empty($data['foto']) && file_exists("uploads/" . $data['foto'])): ?>
                    <img src="uploads/<?= htmlspecialchars($data['foto']) ?>" class="gambar-besar"><br><br>
                <?php else: ?>
                    <span>Tidak ada foto</span><br><br>
                <?php endif; ?>
                <label>Upload Foto Baru (kosongkan jika tidak ingin mengubah):</label>
                <input type="file" name="foto" accept="image/*" class="input-file">
            </div>
            <div class="kolom-input">
                <label>Tipe Kamar:</label>
                <input type="text" name="tipe" value="<?= htmlspecialchars($data['tipe']) ?>" class="input-teks"
                    required>
            </div>
            <div class="kolom-input">
                <label>Harga per Malam:</label>
                <input type="number" name="harga_per_mlm" value="<?= $data['harga_per_mlm'] ?>" class="input-angka"
                    required>
            </div>
            <div class="kolom-input">
                <label>Max Orang:</label>
                <input type="number" name="max_orang" value="<?= $data['max_orang'] ?>" class="input-angka" required>
            </div>
            <div class="kolom-input">
                <button type="submit" class="tombol tombol-utama">Update</button>
            </div>
        </form>
    </div>
</body>

</html>