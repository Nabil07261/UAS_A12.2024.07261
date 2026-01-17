<?php
require_once '../auth.php';
include "../koneksi.php";

$base_url = '../';
$current_page = 'transaksi';

$result = mysqli_query(
    $koneksi,
    "SELECT m.*, p.nama, b.no_kamar as kamar, t.tipe, t.harga_per_mlm 
     FROM menyewa m 
     JOIN penyewa p ON m.id_cust = p.id_cust 
     JOIN bedroom b ON m.no_kamar = b.no_kamar 
     JOIN tipe_kamar t ON b.id_kamar = t.id_kamar
     ORDER BY m.id_sewa DESC"
);
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <title>Data Transaksi - Hotel System</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/dashboard.css">
</head>

<body>
    <div class="dashboard">
        <?php include '../includes/sidebar.php'; ?>

        <main class="main">
            <header class="header">
                <h1 class="page-title">Data Transaksi</h1>
                <div class="header-right">
                    <a href="CetakTransaksiPdf.php" class="btn btn-secondary" target="_blank">🖨️ Cetak PDF</a>
                    <a href="TambahTransaksi.php" class="btn btn-primary">+ Tambah Transaksi</a>
                </div>
            </header>

            <div class="content">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Daftar Transaksi</h3>
                        <span style="color: var(--text-gray); font-size: 14px;">Total: <?= mysqli_num_rows($result) ?>
                            transaksi</span>
                    </div>

                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Penyewa</th>
                                    <th>Kamar</th>
                                    <th>Tipe</th>
                                    <th>Check In</th>
                                    <th>Check Out</th>
                                    <th>Harga/Malam</th>
                                    <th>Total</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1;
                                while ($row = mysqli_fetch_assoc($result)): ?>
                                    <tr>
                                        <td><?= $no++ ?></td>
                                        <td><strong><?= htmlspecialchars($row['nama']) ?></strong></td>
                                        <td><?= htmlspecialchars($row['kamar']) ?></td>
                                        <td><?= htmlspecialchars($row['tipe']) ?></td>
                                        <td><?= date('d/m/Y', strtotime($row['tgl_check_in'])) ?></td>
                                        <td><?= date('d/m/Y', strtotime($row['tgl_check_out'])) ?></td>
                                        <td>Rp <?= number_format($row['harga_per_mlm'], 0, ',', '.') ?></td>
                                        <td><strong style="color: var(--primary);">Rp
                                                <?= number_format($row['total_harga'], 0, ',', '.') ?></strong></td>
                                        <td class="actions">
                                            <a href="KoreksiTransaksi.php?id=<?= $row['id_sewa'] ?>"
                                                class="btn btn-sm btn-secondary">Edit</a>
                                            <a href="HapusTransaksi.php?id=<?= $row['id_sewa'] ?>"
                                                class="btn btn-sm btn-danger"
                                                onclick="return confirm('Hapus transaksi ini?')">Hapus</a>
                                        </td>
                                    </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </main>
    </div>
</body>

</html>