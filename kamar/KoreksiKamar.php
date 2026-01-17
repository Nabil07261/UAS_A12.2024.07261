<?php
require_once '../auth.php';
include "../koneksi.php";

$base_url = '../';
$current_page = 'kamar';

$no = $_GET['id'] ?? '';
$row = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM bedroom WHERE no_kamar = '$no'"));
if (!$row) {
    header('Location: TampilKamar.php');
    exit;
}

$tipe_kamar = mysqli_query($koneksi, "SELECT * FROM tipe_kamar ORDER BY tipe");
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <title>Edit Kamar - Hotel System</title>
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
                        <span>Edit</span>
                    </div>
                    <h1 class="page-title">Edit Data Kamar</h1>
                </div>
            </header>

            <div class="content">
                <div class="card" style="max-width: 600px;">
                    <form action="SimpanKoreksiKamar.php" method="POST">
                        <input type="hidden" name="id" value="<?= $row['no_kamar'] ?>">

                        <div class="form-group">
                            <label class="form-label">No Kamar</label>
                            <input type="text" name="no_kamar" class="form-control" readonly
                                value="<?= htmlspecialchars($row['no_kamar']) ?>"
                                style="background: #f1f5f9; cursor: not-allowed;">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Tipe Kamar</label>
                            <select name="id_kamar" class="form-control" required>
                                <?php while ($t = mysqli_fetch_assoc($tipe_kamar)): ?>
                                    <option value="<?= $t['id_kamar'] ?>" <?= $t['id_kamar'] == $row['id_kamar'] ? 'selected' : '' ?>><?= htmlspecialchars($t['tipe']) ?></option>
                                <?php endwhile; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Lantai</label>
                            <input type="number" name="lantai" class="form-control" required min="1"
                                value="<?= $row['lantai'] ?>">
                        </div>

                        <div style="display: flex; gap: 12px; margin-top: 24px;">
                            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                            <a href="TampilKamar.php" class="btn btn-secondary">Batal</a>
                        </div>
                    </form>
                </div>
            </div>
        </main>
    </div>
</body>

</html>