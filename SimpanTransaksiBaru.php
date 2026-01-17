<?php
require_once 'auth.php';
include 'koneksi.php';

$tipe_penyewa = $_POST['tipe_penyewa']; // 'baru' atau 'existing'
$no_kamar = $_POST['no_kamar'];
$tgl_check_in = $_POST['tgl_check_in'];
$tgl_check_out = $_POST['tgl_check_out'];

// Tentukan id_cust berdasarkan tipe penyewa
if ($tipe_penyewa == 'baru') {
    // Data penyewa baru
    $nama = $_POST['nama'];
    $alamat = $_POST['alamat'];
    $no_telp = $_POST['no_telp'];
    $no_identitas = $_POST['no_identitas'];
    $jenis_identitas = $_POST['jenis_identitas'];

    // Insert penyewa baru dengan prepared statement
    $sql = "INSERT INTO penyewa (nama, alamat, no_telp, no_identitas, jenis_identitas) VALUES (?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($koneksi, $sql);
    mysqli_stmt_bind_param($stmt, "sssss", $nama, $alamat, $no_telp, $no_identitas, $jenis_identitas);

    if (!mysqli_stmt_execute($stmt)) {
        error_log("Error insert penyewa: " . mysqli_error($koneksi));
        $_SESSION['transaksi_error'] = 'Gagal menambahkan penyewa baru!';
        header('Location: transaksi_baru.php');
        exit;
    }
    $id_cust = mysqli_insert_id($koneksi);
    mysqli_stmt_close($stmt);
} else {
    // Penyewa existing
    $id_cust = $_POST['id_cust'];
}

// Hitung lama menginap
$date1 = new DateTime($tgl_check_in);
$date2 = new DateTime($tgl_check_out);
$lama_menginap = $date2->diff($date1)->days;

if ($lama_menginap <= 0) {
    $_SESSION['transaksi_error'] = 'Tanggal check out harus setelah tanggal check in!';
    header('Location: transaksi_baru.php');
    exit;
}

// Get harga kamar dengan prepared statement
$sql_harga = "SELECT t.harga_per_mlm FROM bedroom b JOIN tipe_kamar t ON b.id_kamar = t.id_kamar WHERE b.no_kamar = ?";
$stmt_harga = mysqli_prepare($koneksi, $sql_harga);
mysqli_stmt_bind_param($stmt_harga, "s", $no_kamar);
mysqli_stmt_execute($stmt_harga);
$result = mysqli_stmt_get_result($stmt_harga);
$row = mysqli_fetch_row($result);
$harga = $row[0] ?? 0;
mysqli_stmt_close($stmt_harga);

$total_harga = $lama_menginap * $harga;

// Insert transaksi sewa dengan prepared statement
$sql = "INSERT INTO menyewa (id_cust, no_kamar, tgl_check_in, tgl_check_out, lama_menginap, total_harga) VALUES (?, ?, ?, ?, ?, ?)";
$stmt = mysqli_prepare($koneksi, $sql);
mysqli_stmt_bind_param($stmt, "isssid", $id_cust, $no_kamar, $tgl_check_in, $tgl_check_out, $lama_menginap, $total_harga);

if (mysqli_stmt_execute($stmt)) {
    $_SESSION['transaksi_success'] = 'Transaksi berhasil ditambahkan! Total: Rp ' . number_format($total_harga, 0, ',', '.') . ' (' . $lama_menginap . ' malam)';
} else {
    error_log("Error insert transaksi: " . mysqli_error($koneksi));
    $_SESSION['transaksi_error'] = 'Gagal menyimpan transaksi!';
}

mysqli_stmt_close($stmt);
header('Location: transaksi_baru.php');
exit;
?>