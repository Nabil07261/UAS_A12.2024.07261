<?php
require_once '../auth.php';
include "../koneksi.php";

$id = $_POST['id']; // no_kamar (tidak bisa diubah karena primary key)
$id_kamar = $_POST['id_kamar']; // id tipe kamar
$lantai = $_POST['lantai'];

// Prepared statement untuk mencegah SQL Injection
// no_kamar tidak diupdate karena merupakan primary key
$sql = "UPDATE bedroom SET id_kamar = ?, lantai = ? WHERE no_kamar = ?";
$stmt = mysqli_prepare($koneksi, $sql);
mysqli_stmt_bind_param($stmt, "iis", $id_kamar, $lantai, $id);

if (mysqli_stmt_execute($stmt)) {
    header('Location: TampilKamar.php');
} else {
    error_log("Error update kamar: " . mysqli_error($koneksi));
    header('Location: TampilKamar.php?error=1');
}

mysqli_stmt_close($stmt);
exit;
?>