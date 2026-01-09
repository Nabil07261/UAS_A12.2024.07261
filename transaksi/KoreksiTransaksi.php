<?php
include "../koneksi.php";

$id = mysqli_real_escape_string($koneksi, $_GET['id']);

$penyewa = mysqli_query($koneksi, "SELECT * FROM penyewa ORDER BY nama");
$kamar = mysqli_query($koneksi, "SELECT b.no_kamar, t.tipe, t.harga_per_mlm FROM bedroom b JOIN tipe_kamar t ON b.id_kamar = t.id_kamar ORDER BY b.no_kamar");

$result = mysqli_query($koneksi, "SELECT * FROM menyewa WHERE id_sewa = '$id'");
$data = mysqli_fetch_assoc($result);
?>
<!DOCTYPE html>
<html>

<head>
    <title>Edit Transaksi Sewa</title>
    <link rel="stylesheet" href="../css/style.css">
</head>

<body>
    <div class="wadah">
        <h1 class="judul">Edit Transaksi Sewa</h1>

        <div class="navigasi">
            <a href="TampilTransaksi.php" class="tautan-tombol">Kembali</a>
        </div>

        <form action="SimpanKoreksiTransaksi.php" method="POST" class="formulir">
            <input type="hidden" name="id" value="<?= htmlspecialchars($id) ?>">
            <div class="kolom-input">
                <label>Penyewa:</label>
                <select name="id_cust" class="pilihan" required>
                    <?php while ($p = mysqli_fetch_assoc($penyewa)): ?>
                        <option value="<?= $p['id_cust'] ?>" <?= $p['id_cust'] == $data['id_cust'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($p['nama']) ?>
                        </option>
                    <?php endwhile; ?>
                </select>
            </div>
            <div class="kolom-input">
                <label>Kamar:</label>
                <select name="no_kamar" class="pilihan" required>
                    <?php while ($k = mysqli_fetch_assoc($kamar)): ?>
                        <option value="<?= htmlspecialchars($k['no_kamar']) ?>" <?= $k['no_kamar'] == $data['no_kamar'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($k['no_kamar']) ?> -
                            <?= htmlspecialchars($k['tipe']) ?> (Rp
                            <?= number_format($k['harga_per_mlm'], 0, ',', '.') ?>/malam)
                        </option>
                    <?php endwhile; ?>
                </select>
            </div>
            <div class="kolom-input">
                <label>Tanggal Check In:</label>
                <input type="date" name="tgl_check_in" value="<?= $data['tgl_check_in'] ?>" class="input-tanggal"
                    required>
            </div>
            <div class="kolom-input">
                <label>Tanggal Check Out:</label>
                <input type="date" name="tgl_check_out" value="<?= $data['tgl_check_out'] ?>" class="input-tanggal"
                    required>
            </div>
            <div class="kolom-input">
                <button type="submit" class="tombol tombol-utama">Update</button>
            </div>
        </form>
    </div>
</body>

</html>