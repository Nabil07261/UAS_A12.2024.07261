<?php
require_once '../auth.php';
include "../koneksi.php";

$base_url = '../';
$current_page = 'transaksi';

$today = date('Y-m-d');
$penyewa = mysqli_query($koneksi, "SELECT * FROM penyewa ORDER BY nama");
$kamar = mysqli_query($koneksi, "SELECT b.no_kamar, t.tipe, t.harga_per_mlm FROM bedroom b JOIN tipe_kamar t ON b.id_kamar = t.id_kamar ORDER BY b.no_kamar");
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <title>Tambah Transaksi - Hotel System</title>
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
                        <span>Tambah Baru</span>
                    </div>
                    <h1 class="page-title">Tambah Transaksi Baru</h1>
                </div>
            </header>

            <div class="content">
                <div class="card" style="max-width: 600px;">
                    <form action="SimpanTransaksi.php" method="POST" id="formTransaksi">
                        <div class="form-group">
                            <label class="form-label">Penyewa</label>
                            <select name="id_cust" class="form-control" required>
                                <option value="">-- Pilih Penyewa --</option>
                                <?php while ($p = mysqli_fetch_assoc($penyewa)): ?>
                                    <option value="<?= $p['id_cust'] ?>"><?= htmlspecialchars($p['nama']) ?>
                                        (<?= $p['no_identitas'] ?>)</option>
                                <?php endwhile; ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Kamar</label>
                            <select name="no_kamar" class="form-control" required>
                                <option value="">-- Pilih Kamar --</option>
                                <?php while ($k = mysqli_fetch_assoc($kamar)): ?>
                                    <option value="<?= $k['no_kamar'] ?>"><?= $k['no_kamar'] ?> - <?= $k['tipe'] ?> (Rp
                                        <?= number_format($k['harga_per_mlm'], 0, ',', '.') ?>/malam)</option>
                                <?php endwhile; ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Tanggal Check In</label>
                            <input type="date" name="tgl_check_in" id="tgl_check_in" class="form-control" required
                                min="<?= $today ?>">
                        </div>

                        <div class="form-group">
                            <label class="form-label">Tanggal Check Out</label>
                            <input type="date" name="tgl_check_out" id="tgl_check_out" class="form-control" required
                                min="<?= $today ?>">
                        </div>

                        <div style="display: flex; gap: 12px; margin-top: 24px;">
                            <button type="submit" class="btn btn-primary">Simpan Transaksi</button>
                            <a href="TampilTransaksi.php" class="btn btn-secondary">Batal</a>
                        </div>
                    </form>
                </div>
            </div>
        </main>
    </div>

    <script>
        document.getElementById('tgl_check_in').addEventListener('change', function () {
            var checkIn = this.value;
            var checkOut = document.getElementById('tgl_check_out');
            var nextDay = new Date(checkIn);
            nextDay.setDate(nextDay.getDate() + 1);
            checkOut.min = nextDay.toISOString().split('T')[0];
            if (checkOut.value && checkOut.value <= checkIn) checkOut.value = '';
        });

        document.getElementById('formTransaksi').addEventListener('submit', function (e) {
            var checkIn = document.getElementById('tgl_check_in').value;
            var checkOut = document.getElementById('tgl_check_out').value;
            if (checkOut <= checkIn) {
                alert('Tanggal Check Out harus setelah Check In!');
                e.preventDefault();
            }
        });
    </script>
</body>

</html>