<?php
require_once 'auth.php';
include 'koneksi.php';

// Ambil data kamar yang tersedia
$kamar_result = mysqli_query($koneksi, "SELECT b.no_kamar, t.tipe, t.harga_per_mlm FROM bedroom b JOIN tipe_kamar t ON b.id_kamar = t.id_kamar ORDER BY b.no_kamar");

// Ambil data penyewa untuk dropdown pilih existing
$penyewa_result = mysqli_query($koneksi, "SELECT * FROM penyewa ORDER BY nama");

$error = '';
$success = '';

// Get session messages
if (isset($_SESSION['transaksi_error'])) {
    $error = $_SESSION['transaksi_error'];
    unset($_SESSION['transaksi_error']);
}
if (isset($_SESSION['transaksi_success'])) {
    $success = $_SESSION['transaksi_success'];
    unset($_SESSION['transaksi_success']);
}
?>
<!DOCTYPE html>
<html>

<head>
    <title>Transaksi Hotel Baru</title>
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <div class="wadah">
        <h1 class="judul">Form Transaksi Hotel Baru</h1>

        <div class="navigasi">
            <a href="menu.php" class="tautan-tombol">Kembali ke Menu</a>
            <a href="transaksi/TampilTransaksi.php" class="tautan-tombol">Lihat Semua Transaksi</a>
        </div>

        <?php if ($error): ?>
            <p class="pesan-error"><?= $error ?></p>
        <?php endif; ?>

        <?php if ($success): ?>
            <p class="pesan-sukses"><?= $success ?></p>
        <?php endif; ?>

        <form action="SimpanTransaksiBaru.php" method="POST">
            <div class="kotak">
                <h3 class="judul-kecil">Data Penyewa</h3>

                <div class="kolom-input">
                    <label>Tipe Penyewa:</label><br>
                    <input type="radio" name="tipe_penyewa" value="baru" id="penyewa_baru" checked
                        onclick="togglePenyewaForm()">
                    <label for="penyewa_baru">Penyewa Baru</label>
                    &nbsp;&nbsp;
                    <input type="radio" name="tipe_penyewa" value="existing" id="penyewa_existing"
                        onclick="togglePenyewaForm()">
                    <label for="penyewa_existing">Penyewa Sudah Terdaftar</label>
                </div>

                <div id="form_penyewa_baru">
                    <div class="kolom-input">
                        <label>Nama Lengkap:</label>
                        <input type="text" name="nama" id="nama" class="input-teks">
                    </div>
                    <div class="kolom-input">
                        <label>Alamat:</label>
                        <textarea name="alamat" rows="2" id="alamat" class="area-teks"></textarea>
                    </div>
                    <div class="kolom-input">
                        <label>No Telp:</label>
                        <input type="text" name="no_telp" id="no_telp" class="input-teks">
                    </div>
                    <div class="kolom-input">
                        <label>No Identitas:</label>
                        <input type="text" name="no_identitas" id="no_identitas" class="input-teks">
                    </div>
                    <div class="kolom-input">
                        <label>Jenis Identitas:</label>
                        <select name="jenis_identitas" id="jenis_identitas" class="pilihan">
                            <option value="KTP">KTP</option>
                            <option value="SIM">SIM</option>
                            <option value="Paspor">Paspor</option>
                        </select>
                    </div>
                </div>

                <div id="form_penyewa_existing" style="display:none;">
                    <div class="kolom-input">
                        <label>Pilih Penyewa:</label>
                        <select name="id_cust" id="id_cust" class="pilihan">
                            <option value="">-- Pilih Penyewa --</option>
                            <?php while ($p = mysqli_fetch_assoc($penyewa_result)): ?>
                                <option value="<?= $p['id_cust'] ?>">
                                    <?= htmlspecialchars($p['nama']) ?> (<?= htmlspecialchars($p['no_identitas']) ?>)
                                </option>
                            <?php endwhile; ?>
                        </select>
                    </div>
                </div>
            </div>

            <div class="kotak">
                <h3 class="judul-kecil">Data Kamar & Tanggal</h3>

                <div class="kolom-input">
                    <label>Pilih Kamar:</label>
                    <select name="no_kamar" class="pilihan" required>
                        <option value="">-- Pilih Kamar --</option>
                        <?php while ($k = mysqli_fetch_assoc($kamar_result)): ?>
                            <option value="<?= htmlspecialchars($k['no_kamar']) ?>">
                                Kamar <?= htmlspecialchars($k['no_kamar']) ?> -
                                <?= htmlspecialchars($k['tipe']) ?>
                                (Rp <?= number_format($k['harga_per_mlm'], 0, ',', '.') ?>/malam)
                            </option>
                        <?php endwhile; ?>
                    </select>
                </div>
                <div class="kolom-input">
                    <label>Tanggal Check In:</label>
                    <input type="date" name="tgl_check_in" class="input-tanggal" required>
                </div>
                <div class="kolom-input">
                    <label>Tanggal Check Out:</label>
                    <input type="date" name="tgl_check_out" class="input-tanggal" required>
                </div>
            </div>

            <div class="kolom-input">
                <button type="submit" class="tombol tombol-sukses">Simpan Transaksi</button>
            </div>
        </form>
    </div>

    <script>
        function togglePenyewaForm() {
            var tipeBaru = document.getElementById('penyewa_baru').checked;
            document.getElementById('form_penyewa_baru').style.display = tipeBaru ? 'block' : 'none';
            document.getElementById('form_penyewa_existing').style.display = tipeBaru ? 'none' : 'block';

            // Set required attributes
            document.getElementById('nama').required = tipeBaru;
            document.getElementById('no_identitas').required = tipeBaru;
            document.getElementById('id_cust').required = !tipeBaru;
        }
        // Initialize on load
        togglePenyewaForm();
    </script>
</body>

</html>