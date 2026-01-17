<?php
require_once '../auth.php';
include "../koneksi.php";

$base_url = '../';
$current_page = 'transaksi';

$id = $_GET['id'] ?? '';
$row = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM menyewa WHERE id_sewa = '$id'"));
if (!$row) {
    header('Location: TampilTransaksi.php');
    exit;
}

$penyewa = mysqli_query($koneksi, "SELECT * FROM penyewa ORDER BY nama");
$kamar = mysqli_query($koneksi, "SELECT b.no_kamar, t.tipe FROM bedroom b JOIN tipe_kamar t ON b.id_kamar = t.id_kamar ORDER BY b.no_kamar");
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <title>Edit Transaksi - Hotel System</title>
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
                        <a href="TampilTransaksi.php">Transaksi</a>
                        <span>→</span>
                        <span>Edit</span>
                    </div>
                    <h1 class="page-title">Edit Transaksi</h1>
                </div>
            </header>

            <div class="content">
                <div class="card" style="max-width: 600px;">
                    <form action="SimpanKoreksiTransaksi.php" method="POST">
                        <input type="hidden" name="id" value="<?= $row['id_sewa'] ?>">

                        <div class="form-group">
                            <label class="form-label">Penyewa</label>
                            <select name="id_cust" class="form-control" required>
                                <?php while ($p = mysqli_fetch_assoc($penyewa)): ?>
                                    <option value="<?= $p['id_cust'] ?>" <?= $p['id_cust'] == $row['id_cust'] ? 'selected' : '' ?>><?= htmlspecialchars($p['nama']) ?></option>
                                <?php endwhile; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Kamar</label>
                            <select name="no_kamar" class="form-control" required>
                                <?php while ($k = mysqli_fetch_assoc($kamar)): ?>
                                    <option value="<?= $k['no_kamar'] ?>" <?= $k['no_kamar'] == $row['no_kamar'] ? 'selected' : '' ?>><?= $k['no_kamar'] ?> - <?= $k['tipe'] ?></option>
                                <?php endwhile; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Tanggal Check In</label>
                            <input type="date" name="tgl_check_in" class="form-control" required
                                value="<?= $row['tgl_check_in'] ?>">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Tanggal Check Out</label>
                            <input type="date" name="tgl_check_out" class="form-control" required
                                value="<?= $row['tgl_check_out'] ?>">
                        </div>

                        <div style="display: flex; gap: 12px; margin-top: 24px;">
                            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                            <a href="TampilTransaksi.php" class="btn btn-secondary">Batal</a>
                        </div>
                    </form>
                </div>
            </div>
        </main>
    </div>
</body>

</html>