<?php
require_once '../auth.php';
include "../koneksi.php";

$base_url = '../';
$current_page = 'kamar';

$result = mysqli_query($koneksi, "SELECT b.*, t.tipe, t.harga_per_mlm FROM bedroom b JOIN tipe_kamar t ON b.id_kamar = t.id_kamar ORDER BY b.no_kamar");
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <title>Data Kamar - Hotel System</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/dashboard.css">
</head>

<body>
    <div class="dashboard">
        <?php include '../includes/sidebar.php'; ?>

        <main class="main">
            <header class="header">
                <h1 class="page-title">Data Kamar</h1>
                <div class="header-right">
                    <a href="TambahKamar.php" class="btn btn-primary">+ Tambah Kamar</a>
                </div>
            </header>

            <div class="content">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Daftar Kamar</h3>
                        <span style="color: var(--text-gray); font-size: 14px;">Total: <?= mysqli_num_rows($result) ?>
                            kamar</span>
                    </div>

                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>No Kamar</th>
                                    <th>Tipe</th>
                                    <th>Lantai</th>
                                    <th>Harga/Malam</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1;
                                while ($row = mysqli_fetch_assoc($result)): ?>
                                    <tr>
                                        <td><?= $no++ ?></td>
                                        <td><strong><?= htmlspecialchars($row['no_kamar']) ?></strong></td>
                                        <td><?= htmlspecialchars($row['tipe']) ?></td>
                                        <td>Lantai <?= htmlspecialchars($row['lantai']) ?></td>
                                        <td>Rp <?= number_format($row['harga_per_mlm'], 0, ',', '.') ?></td>
                                        <td class="actions">
                                            <a href="KoreksiKamar.php?id=<?= $row['no_kamar'] ?>"
                                                class="btn btn-sm btn-secondary">Edit</a>
                                            <a href="HapusKamar.php?id=<?= $row['no_kamar'] ?>"
                                                class="btn btn-sm btn-danger"
                                                onclick="return confirm('Hapus kamar ini?')">Hapus</a>
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