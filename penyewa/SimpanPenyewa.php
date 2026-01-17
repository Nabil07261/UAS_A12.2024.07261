<?php
require_once '../auth.php';
include "../koneksi.php";

$nama = $_POST['nama'];
$alamat = $_POST['alamat'];
$no_telp = $_POST['no_telp'];
$no_identitas = $_POST['no_identitas'];
$jenis_identitas = $_POST['jenis_identitas'];

// Prepared statement untuk mencegah SQL Injection
$sql = "INSERT INTO penyewa (nama, alamat, no_telp, no_identitas, jenis_identitas) VALUES (?, ?, ?, ?, ?)";
$stmt = mysqli_prepare($koneksi, $sql);
mysqli_stmt_bind_param($stmt, "sssss", $nama, $alamat, $no_telp, $no_identitas, $jenis_identitas);

if (mysqli_stmt_execute($stmt)) {
    header('Location: TampilPenyewa.php');
} else {
    error_log("Error insert penyewa: " . mysqli_error($koneksi));
    header('Location: TampilPenyewa.php?error=1');
}

mysqli_stmt_close($stmt);
exit;
?>