<?php
include "../koneksi.php";
$data = mysqli_query($koneksi, "SELECT * FROM tipe_kamar ORDER BY id_kamar");
?>
<!DOCTYPE html>
<html>

<head>
    <title>Kelola Tipe Kamar</title>
    <link rel="stylesheet" href="../css/style.css">
</head>

<body>
    <div class="wadah">
        <h1 class="judul">Data Tipe Kamar</h1>
        
        <div class="navigasi">
            <a href="../menu.php" class="tautan-tombol">Kembali ke Menu</a>
            <a href="TambahTipeKamar.php" class="tautan-tombol tautan-sukses">Tambah Tipe Kamar</a>
        </div>

        <table class="tabel">
            <tr>
                <th>ID</th>
                <th>Foto</th>
                <th>Tipe</th>
                <th>Harga per Malam</th>
                <th>Max Orang</th>
                <th>Aksi</th>
            </tr>
            <?php while ($row = mysqli_fetch_assoc($data)): ?>
                <tr>
                    <td class="tabel-tengah"><?= $row['id_kamar'] ?></td>
                    <td class="tabel-tengah">
                        <?php if (!empty($row['foto']) && file_exists("uploads/" . $row['foto'])): ?>
                            <img src="uploads/<?= htmlspecialchars($row['foto']) ?>" class="gambar-sedang">
                        <?php else: ?>
                            <span>-</span>
                        <?php endif; ?>
                    </td>
                    <td><?= htmlspecialchars($row['tipe']) ?></td>
                    <td class="teks-kanan">Rp <?= number_format($row['harga_per_mlm'], 0, ',', '.') ?></td>
                    <td class="tabel-tengah"><?= $row['max_orang'] ?></td>
                    <td class="aksi tabel-tengah">
                        <a href="KoreksiTipeKamar.php?id=<?= $row['id_kamar'] ?>" class="edit">Edit</a>
                        <a href="HapusTipeKamar.php?id=<?= $row['id_kamar'] ?>" class="hapus"
                            onclick="return confirm('Yakin hapus?')">Hapus</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </table>
    </div>
</body>

</html>