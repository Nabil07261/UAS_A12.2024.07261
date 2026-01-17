<?php
require_once '../auth.php';
include "../koneksi.php";

$no_kamar = $_POST['no_kamar'];
$id_kamar = $_POST['id_kamar'];
$lantai = $_POST['lantai'];

// Prepared statement untuk mencegah SQL Injection
$sql = "INSERT INTO bedroom (no_kamar, id_kamar, lantai) VALUES (?, ?, ?)";
$stmt = mysqli_prepare($koneksi, $sql);
mysqli_stmt_bind_param($stmt, "ssi", $no_kamar, $id_kamar, $lantai);

if (mysqli_stmt_execute($stmt)) {
    header('Location: TampilKamar.php');
} else {
    error_log("Error insert kamar: " . mysqli_error($koneksi));
    header('Location: TampilKamar.php?error=1');
}

mysqli_stmt_close($stmt);
exit;
?>