<?php
require_once '../auth.php';
include "../koneksi.php";

$id_cust = $_POST['id_cust'];
$no_kamar = $_POST['no_kamar'];
$tgl_check_in = $_POST['tgl_check_in'];
$tgl_check_out = $_POST['tgl_check_out'];

// Calculate days
$date1 = new DateTime($tgl_check_in);
$date2 = new DateTime($tgl_check_out);
$lama_menginap = $date2->diff($date1)->days;

// Get room price dengan prepared statement
$sql_harga = "SELECT t.harga_per_mlm FROM bedroom b JOIN tipe_kamar t ON b.id_kamar = t.id_kamar WHERE b.no_kamar = ?";
$stmt_harga = mysqli_prepare($koneksi, $sql_harga);
mysqli_stmt_bind_param($stmt_harga, "s", $no_kamar);
mysqli_stmt_execute($stmt_harga);
$result = mysqli_stmt_get_result($stmt_harga);
$row = mysqli_fetch_row($result);
$harga = $row[0] ?? 0;
mysqli_stmt_close($stmt_harga);

$total_harga = $lama_menginap * $harga;

// Insert dengan prepared statement
$sql = "INSERT INTO menyewa (id_cust, no_kamar, tgl_check_in, tgl_check_out, lama_menginap, total_harga) VALUES (?, ?, ?, ?, ?, ?)";
$stmt = mysqli_prepare($koneksi, $sql);
mysqli_stmt_bind_param($stmt, "isssid", $id_cust, $no_kamar, $tgl_check_in, $tgl_check_out, $lama_menginap, $total_harga);

if (mysqli_stmt_execute($stmt)) {
    header('Location: TampilTransaksi.php');
} else {
    error_log("Error insert transaksi: " . mysqli_error($koneksi));
    header('Location: TampilTransaksi.php?error=1');
}

mysqli_stmt_close($stmt);
exit;
?>