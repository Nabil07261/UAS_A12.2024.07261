<?php
include "../koneksi.php";

$id = $_GET['id'];

$result = mysqli_query($koneksi, "SELECT * FROM users WHERE id = '$id'");
$data = mysqli_fetch_assoc($result);
?>
<!DOCTYPE html>
<html>

<head>
    <title>Edit User</title>
    <link rel="stylesheet" href="../css/style.css">
</head>

<body>
    <div class="wadah">
        <h1 class="judul">Edit User</h1>

        <div class="navigasi">
            <a href="TampilUser.php" class="tautan-tombol">Kembali</a>
        </div>

        <form action="SimpanKoreksiUser.php" method="POST" enctype="multipart/form-data" class="formulir">
            <input type="hidden" name="id" value="<?= $id ?>">
            <input type="hidden" name="foto_lama" value="<?= htmlspecialchars($data['foto'] ?? '') ?>">

            <div class="kolom-input">
                <label>Foto Saat Ini:</label><br>
                <?php if (!empty($data['foto']) && file_exists("uploads/" . $data['foto'])): ?>
                    <img src="uploads/<?= htmlspecialchars($data['foto']) ?>" class="gambar-sedang"><br><br>
                <?php else: ?>
                    <span>Tidak ada foto</span><br><br>
                <?php endif; ?>
                <label>Upload Foto Baru (kosongkan jika tidak ingin mengubah):</label>
                <input type="file" name="foto" accept="image/*" class="input-file">
            </div>
            <div class="kolom-input">
                <label>Username:</label>
                <input type="text" name="username" value="<?= htmlspecialchars($data['username']) ?>" class="input-teks"
                    required>
            </div>
            <div class="kolom-input">
                <label>Nama Lengkap:</label>
                <input type="text" name="nama" value="<?= htmlspecialchars($data['nama']) ?>" class="input-teks"
                    required>
            </div>
            <div class="kolom-input">
                <label>Password Baru (kosongkan jika tidak ingin mengubah):</label>
                <input type="password" name="password" class="input-password">
            </div>
            <div class="kolom-input">
                <button type="submit" class="tombol tombol-utama">Update</button>
            </div>
        </form>
    </div>
</body>

</html>