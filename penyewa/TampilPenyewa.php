<?php
require_once '../auth.php';
include "../koneksi.php";

$base_url = '../';
$current_page = 'penyewa';

$result = mysqli_query($koneksi, "SELECT * FROM penyewa ORDER BY nama");
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <title>Data Penyewa - Hotel System</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/dashboard.css">
</head>

<body>
    <div class="dashboard">
        <?php include '../includes/sidebar.php'; ?>

        <main class="main">
            <header class="header">
                <h1 class="page-title">Data Penyewa</h1>
                <div class="header-right">
                    <a href="TambahPenyewa.php" class="btn btn-primary">+ Tambah Penyewa</a>
                </div>
            </header>

            <div class="content">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Daftar Penyewa</h3>
                        <span style="color: var(--text-gray); font-size: 14px;">Total: <?= mysqli_num_rows($result) ?>
                            penyewa</span>
                    </div>

                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama</th>
                                    <th>Alamat</th>
                                    <th>No Telp</th>
                                    <th>No Identitas</th>
                                    <th>Jenis</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1;
                                while ($row = mysqli_fetch_assoc($result)): ?>
                                    <tr>
                                        <td><?= $no++ ?></td>
                                        <td><strong><?= htmlspecialchars($row['nama']) ?></strong></td>
                                        <td><?= htmlspecialchars($row['alamat']) ?></td>
                                        <td><?= htmlspecialchars($row['no_telp']) ?></td>
                                        <td><?= htmlspecialchars($row['no_identitas']) ?></td>
                                        <td><?= htmlspecialchars($row['jenis_identitas']) ?></td>
                                        <td class="actions">
                                            <a href="KoreksiPenyewa.php?id=<?= $row['id_cust'] ?>"
                                                class="btn btn-sm btn-secondary">Edit</a>
                                            <a href="HapusPenyewa.php?id=<?= $row['id_cust'] ?>"
                                                class="btn btn-sm btn-danger"
                                                onclick="return confirm('Hapus penyewa ini?')">Hapus</a>
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