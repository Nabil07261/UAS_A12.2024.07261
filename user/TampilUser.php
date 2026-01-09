<?php
include "../koneksi.php";

$data = mysqli_query($koneksi, "SELECT * FROM users ORDER BY id DESC");
?>
<!DOCTYPE html>
<html>

<head>
    <title>Data User</title>
    <link rel="stylesheet" href="../css/style.css">
</head>

<body>
    <div class="wadah">
        <h1 class="judul">Daftar User</h1>

        <div class="navigasi">
            <a href="../menu.php" class="tautan-tombol">Kembali ke Menu</a>
            <a href="TambahUser.php" class="tautan-tombol tautan-sukses">Tambah User</a>
        </div>

        <table class="tabel">
            <tr>
                <th>ID</th>
                <th>Foto</th>
                <th>Username</th>
                <th>Nama</th>
                <th>Created At</th>
                <th>Aksi</th>
            </tr>
            <?php while ($row = mysqli_fetch_assoc($data)): ?>
                <tr>
                    <td class="tabel-tengah"><?= $row['id'] ?></td>
                    <td class="tabel-tengah">
                        <?php if (!empty($row['foto']) && file_exists("uploads/" . $row['foto'])): ?>
                            <img src="uploads/<?= htmlspecialchars($row['foto']) ?>" class="gambar-kecil">
                        <?php else: ?>
                            <span>-</span>
                        <?php endif; ?>
                    </td>
                    <td><?= htmlspecialchars($row['username']) ?></td>
                    <td><?= htmlspecialchars($row['nama']) ?></td>
                    <td class="tabel-tengah"><?= $row['created_at'] ?></td>
                    <td class="aksi tabel-tengah">
                        <a href="KoreksiUser.php?id=<?= $row['id'] ?>" class="edit">Edit</a>
                        <a href="HapusUser.php?id=<?= $row['id'] ?>" class="hapus"
                            onclick="return confirm('Yakin hapus user ini?')">Hapus</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </table>
    </div>
</body>

</html>