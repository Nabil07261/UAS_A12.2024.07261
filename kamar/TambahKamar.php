<?php
require_once '../auth.php';
include "../koneksi.php";

$base_url = '../';
$current_page = 'kamar';

$tipe_kamar = mysqli_query($koneksi, "SELECT * FROM tipe_kamar ORDER BY tipe");
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <title>Tambah Kamar - Hotel System</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/dashboard.css">
</head>

<body>
    <div class="dashboard">
        <?php include '../includes/sidebar.php'; ?>

        <main class="main">
            <header class="header">
                <div>
                    <div class="breadcrumb">
                        <a href="TampilKamar.php">Kamar</a>
                        <span>→</span>
                        <span>Tambah Baru</span>
                    </div>
                    <h1 class="page-title">Tambah Kamar Baru</h1>
                </div>
            </header>

            <div class="content">
                <div class="card" style="max-width: 600px;">
                    <form action="SimpanKamar.php" method="POST">
                        <div class="form-group">
                            <label class="form-label">No Kamar</label>
                            <input type="text" name="no_kamar" class="form-control" required pattern="[A-Za-z0-9]{1,10}"
                                placeholder="Contoh: 101, A1">
                        </div>

                        <div class="form-group">
                            <label class="form-label">Tipe Kamar</label>
                            <select name="id_kamar" class="form-control" required>
                                <option value="">-- Pilih Tipe --</option>
                                <?php while ($t = mysqli_fetch_assoc($tipe_kamar)): ?>
                                    <option value="<?= $t['id_kamar'] ?>"><?= htmlspecialchars($t['tipe']) ?> - Rp
                                        <?= number_format($t['harga_per_mlm'], 0, ',', '.') ?>/malam</option>
                                <?php endwhile; ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Lantai</label>
                            <input type="number" name="lantai" class="form-control" required min="1" max="100"
                                placeholder="Nomor lantai">
                        </div>

                        <div style="display: flex; gap: 12px; margin-top: 24px;">
                            <button type="submit" class="btn btn-primary">Simpan Kamar</button>
                            <a href="TampilKamar.php" class="btn btn-secondary">Batal</a>
                        </div>
                    </form>
                </div>
            </div>
        </main>
    </div>
</body>

</html>