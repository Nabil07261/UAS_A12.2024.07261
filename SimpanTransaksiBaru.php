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

    // Insert penyewa baru
    $sql = "INSERT INTO penyewa (nama, alamat, no_telp, no_identitas, jenis_identitas) VALUES ('$nama', '$alamat', '$no_telp', '$no_identitas', '$jenis_identitas')";
    mysqli_query($koneksi, $sql) or die(mysqli_error($koneksi));
    $id_cust = mysqli_insert_id($koneksi);
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

// Get harga kamar
$result = mysqli_query($koneksi, "SELECT t.harga_per_mlm FROM bedroom b JOIN tipe_kamar t ON b.id_kamar = t.id_kamar WHERE b.no_kamar = '$no_kamar'");
$harga = mysqli_fetch_row($result)[0];

$total_harga = $lama_menginap * $harga;

// Insert transaksi sewa
$sql = "INSERT INTO menyewa (id_cust, no_kamar, tgl_check_in, tgl_check_out, lama_menginap, total_harga) VALUES ('$id_cust', '$no_kamar', '$tgl_check_in', '$tgl_check_out', '$lama_menginap', '$total_harga')";
mysqli_query($koneksi, $sql) or die(mysqli_error($koneksi));

$_SESSION['transaksi_success'] = 'Transaksi berhasil ditambahkan! Total: Rp ' . number_format($total_harga, 0, ',', '.') . ' (' . $lama_menginap . ' malam)';
header('Location: transaksi_baru.php');
?>