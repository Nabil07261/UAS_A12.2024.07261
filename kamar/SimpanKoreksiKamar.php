<?php
include "../koneksi.php";

$id = $_POST['id'];
$id_kamar = $_POST['id_kamar'];
$lantai = $_POST['lantai'];

$sql = "UPDATE bedroom SET id_kamar = '$id_kamar', lantai = '$lantai' WHERE no_kamar = '$id'";
mysqli_query($koneksi, $sql) or die(mysqli_error($koneksi));

header('Location: TampilKamar.php');
?>