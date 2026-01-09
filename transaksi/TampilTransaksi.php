<?php
include "../koneksi.php";
$data = mysqli_query($koneksi, "SELECT m.*, p.nama, b.no_kamar as kamar FROM menyewa m 
                     JOIN penyewa p ON m.id_cust = p.id_cust 
                     JOIN bedroom b ON m.no_kamar = b.no_kamar 
                     ORDER BY m.id_sewa DESC");
?>
<!DOCTYPE html>
<html>

<head>
    <title>Kelola Transaksi Sewa</title>
    <link rel="stylesheet" href="../css/style.css">
</head>

<body>
    <div class="wadah">
        <h1 class="judul">Data Transaksi Sewa</h1>

        <div class="navigasi">
            <a href="../menu.php" class="tautan-tombol">Kembali ke Menu</a>
            <a href="CetakTransaksiPdf.php" class="tautan-tombol">Cetak PDF</a>
        </div>

        <table class="tabel">
            <tr>
                <th>ID</th>
                <th>Nama Penyewa</th>
                <th>No Kamar</th>
                <th>Check In</th>
                <th>Check Out</th>
                <th>Lama</th>
                <th>Total Harga</th>
                <th>Aksi</th>
            </tr>
            <?php while ($row = mysqli_fetch_assoc($data)): ?>
                <tr>
                    <td class="tabel-tengah"><?= $row['id_sewa'] ?></td>
                    <td><?= htmlspecialchars($row['nama']) ?></td>
                    <td class="tabel-tengah"><?= htmlspecialchars($row['kamar']) ?></td>
                    <td class="tabel-tengah"><?= $row['tgl_check_in'] ?></td>
                    <td class="tabel-tengah"><?= $row['tgl_check_out'] ?></td>
                    <td class="tabel-tengah"><?= $row['lama_menginap'] ?> mlm</td>
                    <td class="teks-kanan">Rp <?= number_format($row['total_harga'], 0, ',', '.') ?></td>
                    <td class="aksi tabel-tengah">
                        <a href="KoreksiTransaksi.php?id=<?= $row['id_sewa'] ?>" class="edit">Edit</a>
                        <a href="HapusTransaksi.php?id=<?= $row['id_sewa'] ?>" class="hapus"
                            onclick="return confirm('Yakin hapus?')">Hapus</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </table>
    </div>
</body>

</html>