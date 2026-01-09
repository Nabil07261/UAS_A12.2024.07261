<?php
include "../koneksi.php";

$id = mysqli_real_escape_string($koneksi, $_GET['id']);

$sql = "DELETE FROM bedroom WHERE no_kamar = '$id'";
mysqli_query($koneksi, $sql) or die(mysqli_error($koneksi));

header('Location: TampilKamar.php');
exit;
?>