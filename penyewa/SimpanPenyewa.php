<?php
include "../koneksi.php";

$nama = $_POST['nama'];
$alamat = $_POST['alamat'];
$no_telp = $_POST['no_telp'];
$no_identitas = $_POST['no_identitas'];
$jenis_identitas = $_POST['jenis_identitas'];

$sql = "INSERT INTO penyewa (nama, alamat, no_telp, no_identitas, jenis_identitas) VALUES ('$nama', '$alamat', '$no_telp', '$no_identitas', '$jenis_identitas')";
mysqli_query($koneksi, $sql) or die(mysqli_error($koneksi));

header('Location: TampilPenyewa.php');
?>