<?php
include "../koneksi.php";
$data = mysqli_query($koneksi, "SELECT b.*, t.tipe FROM bedroom b JOIN tipe_kamar t ON b.id_kamar = t.id_kamar ORDER BY b.no_kamar");
?>
<!DOCTYPE html>
<html>

<head>
    <title>Kelola Kamar</title>
    <link rel="stylesheet" href="../css/style.css">
</head>

<body>
    <div class="wadah">
        <h1 class="judul">Data Kamar</h1>

        <div class="navigasi">
            <a href="../menu.php" class="tautan-tombol">Kembali ke Menu</a>
            <a href="TambahKamar.php" class="tautan-tombol tautan-sukses">Tambah Kamar</a>
        </div>

        <table class="tabel">
            <tr>
                <th>No Kamar</th>
                <th>Tipe Kamar</th>
                <th>Lantai</th>
                <th>Aksi</th>
            </tr>
            <?php while ($row = mysqli_fetch_assoc($data)): ?>
                <tr>
                    <td class="tabel-tengah"><?= htmlspecialchars($row['no_kamar']) ?></td>
                    <td><?= htmlspecialchars($row['tipe']) ?></td>
                    <td class="tabel-tengah"><?= $row['lantai'] ?></td>
                    <td class="aksi tabel-tengah">
                        <a href="KoreksiKamar.php?id=<?= urlencode($row['no_kamar']) ?>" class="edit">Edit</a>
                        <a href="HapusKamar.php?id=<?= urlencode($row['no_kamar']) ?>" class="hapus"
                            onclick="return confirm('Yakin hapus?')">Hapus</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </table>
    </div>
</body>

</html>