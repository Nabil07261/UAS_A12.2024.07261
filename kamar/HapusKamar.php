<?php
require_once '../auth.php';
include "../koneksi.php";

$id = $_GET['id'] ?? '';

if (empty($id)) {
    header('Location: TampilKamar.php');
    exit;
}

// Prepared statement untuk mencegah SQL Injection
$sql = "DELETE FROM bedroom WHERE no_kamar = ?";
$stmt = mysqli_prepare($koneksi, $sql);
mysqli_stmt_bind_param($stmt, "s", $id);

if (mysqli_stmt_execute($stmt)) {
    header('Location: TampilKamar.php');
} else {
    error_log("Error hapus kamar: " . mysqli_error($koneksi));
    header('Location: TampilKamar.php?error=1');
}

mysqli_stmt_close($stmt);
exit;
?>