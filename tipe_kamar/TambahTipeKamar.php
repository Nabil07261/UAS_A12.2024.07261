<?php
require_once '../auth.php';
include "../koneksi.php";

$base_url = '../';
$current_page = 'tipe_kamar';
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <title>Tambah Tipe Kamar - Hotel System</title>
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
                        <a href="TampilTipeKamar.php">Tipe Kamar</a>
                        <span>→</span>
                        <span>Tambah Baru</span>
                    </div>
                    <h1 class="page-title">Tambah Tipe Kamar Baru</h1>
                </div>
            </header>

            <div class="content">
                <div class="card" style="max-width: 600px;">
                    <form action="SimpanTipeKamar.php" method="POST" enctype="multipart/form-data">
                        <div class="form-group">
                            <label class="form-label">Foto Kamar</label>
                            <input type="file" name="foto_kamar" class="form-control" accept="image/*" required>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Nama Tipe</label>
                            <input type="text" name="tipe" class="form-control" required minlength="3" maxlength="50"
                                placeholder="Contoh: Deluxe, Standard">
                        </div>

                        <div class="form-group">
                            <label class="form-label">Harga per Malam (Rp)</label>
                            <input type="number" name="harga_per_mlm" class="form-control" required min="1"
                                placeholder="Contoh: 500000">
                        </div>

                        <div class="form-group">
                            <label class="form-label">Maksimal Orang</label>
                            <input type="number" name="max_orang" class="form-control" required min="1" max="10"
                                placeholder="Kapasitas maksimal">
                        </div>

                        <div style="display: flex; gap: 12px; margin-top: 24px;">
                            <button type="submit" class="btn btn-primary">Simpan Tipe</button>
                            <a href="TampilTipeKamar.php" class="btn btn-secondary">Batal</a>
                        </div>
                    </form>
                </div>
            </div>
        </main>
    </div>
</body>

</html>