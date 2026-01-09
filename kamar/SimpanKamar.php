<?php
include "../koneksi.php";

$no_kamar = $_POST['no_kamar'];
$id_kamar = $_POST['id_kamar'];
$lantai = $_POST['lantai'];

$sql = "INSERT INTO bedroom (no_kamar, id_kamar, lantai) VALUES ('$no_kamar', '$id_kamar', '$lantai')";
mysqli_query($koneksi, $sql) or die(mysqli_error($koneksi));

header('Location: TampilKamar.php');
?>