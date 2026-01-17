<?php
require_once '../auth.php';
include "../koneksi.php";

$base_url = '../';
$current_page = 'tipe_kamar';

$result = mysqli_query($koneksi, "SELECT * FROM tipe_kamar ORDER BY tipe");
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <title>Tipe Kamar - Hotel System</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/dashboard.css">
</head>

<body>
    <div class="dashboard">
        <?php include '../includes/sidebar.php'; ?>

        <main class="main">
            <header class="header">
                <h1 class="page-title">Tipe Kamar</h1>
                <div class="header-right">
                    <a href="TambahTipeKamar.php" class="btn btn-primary">+ Tambah Tipe</a>
                </div>
            </header>

            <div class="content">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Daftar Tipe Kamar</h3>
                        <span style="color: var(--text-gray); font-size: 14px;">Total: <?= mysqli_num_rows($result) ?>
                            tipe</span>
                    </div>

                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Foto</th>
                                    <th>Tipe</th>
                                    <th>Harga/Malam</th>
                                    <th>Max Orang</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1;
                                while ($row = mysqli_fetch_assoc($result)): ?>
                                    <tr>
                                        <td><?= $no++ ?></td>
                                        <td><img src="uploads/<?= htmlspecialchars($row['foto']) ?>"
                                                alt="<?= htmlspecialchars($row['tipe']) ?>"></td>
                                        <td><strong><?= htmlspecialchars($row['tipe']) ?></strong></td>
                                        <td>Rp <?= number_format($row['harga_per_mlm'], 0, ',', '.') ?></td>
                                        <td><?= $row['max_orang'] ?> orang</td>
                                        <td class="actions">
                                            <a href="KoreksiTipeKamar.php?id=<?= $row['id_kamar'] ?>"
                                                class="btn btn-sm btn-secondary">Edit</a>
                                            <a href="HapusTipeKamar.php?id=<?= $row['id_kamar'] ?>"
                                                class="btn btn-sm btn-danger"
                                                onclick="return confirm('Hapus tipe ini?')">Hapus</a>
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