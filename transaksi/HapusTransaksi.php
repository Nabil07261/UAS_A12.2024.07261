<?php
include "../koneksi.php";

$id = mysqli_real_escape_string($koneksi, $_GET['id']);

$sql = "DELETE FROM menyewa WHERE id_sewa = '$id'";
mysqli_query($koneksi, $sql) or die(mysqli_error($koneksi));

header('Location: TampilTransaksi.php');
exit;
?>