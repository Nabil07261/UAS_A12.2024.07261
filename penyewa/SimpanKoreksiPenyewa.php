<?php
require_once '../auth.php';
include "../koneksi.php";

$id = $_POST['id'];
$nama = $_POST['nama'];
$alamat = $_POST['alamat'];
$no_telp = $_POST['no_telp'];
$no_identitas = $_POST['no_identitas'];
$jenis_identitas = $_POST['jenis_identitas'];

// Prepared statement untuk mencegah SQL Injection
$sql = "UPDATE penyewa SET nama = ?, alamat = ?, no_telp = ?, no_identitas = ?, jenis_identitas = ? WHERE id_cust = ?";
$stmt = mysqli_prepare($koneksi, $sql);
mysqli_stmt_bind_param($stmt, "sssssi", $nama, $alamat, $no_telp, $no_identitas, $jenis_identitas, $id);

if (mysqli_stmt_execute($stmt)) {
    header('Location: TampilPenyewa.php');
} else {
    error_log("Error update penyewa: " . mysqli_error($koneksi));
    header('Location: TampilPenyewa.php?error=1');
}

mysqli_stmt_close($stmt);
exit;
?>