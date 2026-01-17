<?php
require_once '../auth.php';
include "../koneksi.php";

$base_url = '../';
$current_page = 'penyewa';
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <title>Tambah Penyewa - Hotel System</title>
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
                        <span>Tambah Baru</span>
                    </div>
                    <h1 class="page-title">Tambah Penyewa Baru</h1>
                </div>
            </header>

            <div class="content">
                <div class="card" style="max-width: 600px;">
                    <form action="SimpanPenyewa.php" method="POST">
                        <div class="form-group">
                            <label class="form-label">Nama Lengkap</label>
                            <input type="text" name="nama" class="form-control" required minlength="3"
                                placeholder="Masukkan nama lengkap">
                        </div>

                        <div class="form-group">
                            <label class="form-label">Alamat</label>
                            <textarea name="alamat" class="form-control" required rows="3"
                                placeholder="Masukkan alamat lengkap"></textarea>
                        </div>

                        <div class="form-group">
                            <label class="form-label">No Telepon</label>
                            <input type="tel" name="no_telp" class="form-control" required pattern="[0-9]{10,13}"
                                placeholder="Contoh: 081234567890">
                        </div>

                        <div class="form-group">
                            <label class="form-label">No Identitas</label>
                            <input type="text" name="no_identitas" class="form-control" required minlength="16"
                                maxlength="16" placeholder="16 digit nomor identitas">
                        </div>

                        <div class="form-group">
                            <label class="form-label">Jenis Identitas</label>
                            <select name="jenis_identitas" class="form-control" required>
                                <option value="KTP">KTP</option>
                                <option value="SIM">SIM</option>
                                <option value="Paspor">Paspor</option>
                            </select>
                        </div>

                        <div style="display: flex; gap: 12px; margin-top: 24px;">
                            <button type="submit" class="btn btn-primary">Simpan Penyewa</button>
                            <a href="TampilPenyewa.php" class="btn btn-secondary">Batal</a>
                        </div>
                    </form>
                </div>
            </div>
        </main>
    </div>
</body>

</html>