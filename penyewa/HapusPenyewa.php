<?php
require_once '../auth.php';
include "../koneksi.php";

$id = $_GET['id'] ?? '';

if (empty($id)) {
    header('Location: TampilPenyewa.php');
    exit;
}

// Prepared statement untuk mencegah SQL Injection
$sql = "DELETE FROM penyewa WHERE id_cust = ?";
$stmt = mysqli_prepare($koneksi, $sql);
mysqli_stmt_bind_param($stmt, "i", $id);

if (mysqli_stmt_execute($stmt)) {
    header('Location: TampilPenyewa.php');
} else {
    error_log("Error hapus penyewa: " . mysqli_error($koneksi));
    header('Location: TampilPenyewa.php?error=1');
}

mysqli_stmt_close($stmt);
exit;
?>