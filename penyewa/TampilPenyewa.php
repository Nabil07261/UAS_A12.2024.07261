<?php
include "../koneksi.php";
$data = mysqli_query($koneksi, "SELECT * FROM penyewa ORDER BY id_cust");
?>
<!DOCTYPE html>
<html>

<head>
    <title>Kelola Penyewa</title>
    <link rel="stylesheet" href="../css/style.css">
</head>

<body>
    <div class="wadah">
        <h1 class="judul">Data Penyewa</h1>

        <div class="navigasi">
            <a href="../menu.php" class="tautan-tombol">Kembali ke Menu</a>
            <a href="TambahPenyewa.php" class="tautan-tombol tautan-sukses">Tambah Penyewa</a>
        </div>

        <table class="tabel">
            <tr>
                <th>ID</th>
                <th>Nama</th>
                <th>Alamat</th>
                <th>No Telp</th>
                <th>No Identitas</th>
                <th>Jenis</th>
                <th>Aksi</th>
            </tr>
            <?php while ($row = mysqli_fetch_assoc($data)): ?>
                <tr>
                    <td class="tabel-tengah"><?= $row['id_cust'] ?></td>
                    <td><?= htmlspecialchars($row['nama']) ?></td>
                    <td><?= htmlspecialchars($row['alamat']) ?></td>
                    <td><?= htmlspecialchars($row['no_telp']) ?></td>
                    <td><?= htmlspecialchars($row['no_identitas']) ?></td>
                    <td class="tabel-tengah"><?= htmlspecialchars($row['jenis_identitas']) ?></td>
                    <td class="aksi tabel-tengah">
                        <a href="KoreksiPenyewa.php?id=<?= $row['id_cust'] ?>" class="edit">Edit</a>
                        <a href="HapusPenyewa.php?id=<?= $row['id_cust'] ?>" class="hapus"
                            onclick="return confirm('Yakin hapus?')">Hapus</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </table>
    </div>
</body>

</html>