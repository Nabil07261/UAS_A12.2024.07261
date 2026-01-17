<?php
require_once '../auth.php';
include "../koneksi.php";

$id = $_GET['id'] ?? '';

if (empty($id)) {
    header('Location: TampilTransaksi.php');
    exit;
}

// Prepared statement untuk mencegah SQL Injection
$sql = "DELETE FROM menyewa WHERE id_sewa = ?";
$stmt = mysqli_prepare($koneksi, $sql);
mysqli_stmt_bind_param($stmt, "i", $id);

if (mysqli_stmt_execute($stmt)) {
    header('Location: TampilTransaksi.php');
} else {
    error_log("Error hapus transaksi: " . mysqli_error($koneksi));
    header('Location: TampilTransaksi.php?error=1');
}

mysqli_stmt_close($stmt);
exit;
?>