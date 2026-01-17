<?php
require_once '../auth.php';
include "../koneksi.php";

$base_url = '../';
$current_page = 'tipe_kamar';

$id = $_GET['id'] ?? '';
$row = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM tipe_kamar WHERE id_kamar = '$id'"));
if (!$row) {
    header('Location: TampilTipeKamar.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <title>Edit Tipe Kamar - Hotel System</title>
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
                        <span>Edit</span>
                    </div>
                    <h1 class="page-title">Edit Tipe Kamar</h1>
                </div>
            </header>

            <div class="content">
                <div class="card" style="max-width: 600px;">
                    <div style="margin-bottom: 20px;">
                        <img src="uploads/<?= htmlspecialchars($row['foto']) ?>" alt=""
                            style="max-width: 200px; border-radius: 10px;">
                    </div>

                    <form action="SimpanKoreksiTipeKamar.php" method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="id" value="<?= $row['id_kamar'] ?>">
                        <input type="hidden" name="foto_lama" value="<?= $row['foto'] ?>">

                        <div class="form-group">
                            <label class="form-label">Foto Baru (opsional)</label>
                            <input type="file" name="foto_kamar" class="form-control" accept="image/*">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Nama Tipe</label>
                            <input type="text" name="tipe" class="form-control" required
                                value="<?= htmlspecialchars($row['tipe']) ?>">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Harga per Malam (Rp)</label>
                            <input type="number" name="harga_per_mlm" class="form-control" required min="1"
                                value="<?= $row['harga_per_mlm'] ?>">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Maksimal Orang</label>
                            <input type="number" name="max_orang" class="form-control" required min="1" max="10"
                                value="<?= $row['max_orang'] ?>">
                        </div>

                        <div style="display: flex; gap: 12px; margin-top: 24px;">
                            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                            <a href="TampilTipeKamar.php" class="btn btn-secondary">Batal</a>
                        </div>
                    </form>
                </div>
            </div>
        </main>
    </div>
</body>

</html>