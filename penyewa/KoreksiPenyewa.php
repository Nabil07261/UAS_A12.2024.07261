<?php
require_once '../auth.php';
include "../koneksi.php";

$base_url = '../';
$current_page = 'penyewa';

$id = $_GET['id'] ?? '';
$row = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM penyewa WHERE id_cust = '$id'"));
if (!$row) {
    header('Location: TampilPenyewa.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <title>Edit Penyewa - Hotel System</title>
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
                        <a href="TampilPenyewa.php">Penyewa</a>
                        <span>→</span>
                        <span>Edit</span>
                    </div>
                    <h1 class="page-title">Edit Data Penyewa</h1>
                </div>
            </header>

            <div class="content">
                <div class="card" style="max-width: 600px;">
                    <form action="SimpanKoreksiPenyewa.php" method="POST">
                        <input type="hidden" name="id" value="<?= $row['id_cust'] ?>">

                        <div class="form-group">
                            <label class="form-label">Nama Lengkap</label>
                            <input type="text" name="nama" class="form-control" required minlength="3"
                                value="<?= htmlspecialchars($row['nama']) ?>">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Alamat</label>
                            <textarea name="alamat" class="form-control" required
                                rows="3"><?= htmlspecialchars($row['alamat']) ?></textarea>
                        </div>
                        <div class="form-group">
                            <label class="form-label">No Telepon</label>
                            <input type="tel" name="no_telp" class="form-control" required
                                value="<?= htmlspecialchars($row['no_telp']) ?>">
                        </div>
                        <div class="form-group">
                            <label class="form-label">No Identitas</label>
                            <input type="text" name="no_identitas" class="form-control" required
                                value="<?= htmlspecialchars($row['no_identitas']) ?>">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Jenis Identitas</label>
                            <select name="jenis_identitas" class="form-control" required>
                                <option value="KTP" <?= $row['jenis_identitas'] == 'KTP' ? 'selected' : '' ?>>KTP</option>
                                <option value="SIM" <?= $row['jenis_identitas'] == 'SIM' ? 'selected' : '' ?>>SIM</option>
                                <option value="Paspor" <?= $row['jenis_identitas'] == 'Paspor' ? 'selected' : '' ?>>Paspor
                                </option>
                            </select>
                        </div>

                        <div style="display: flex; gap: 12px; margin-top: 24px;">
                            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                            <a href="TampilPenyewa.php" class="btn btn-secondary">Batal</a>
                        </div>
                    </form>
                </div>
            </div>
        </main>
    </div>
</body>

</html>