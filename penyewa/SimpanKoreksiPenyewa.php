<?php
include "../koneksi.php";

$id = $_POST['id'];
$nama = $_POST['nama'];
$alamat = $_POST['alamat'];
$no_telp = $_POST['no_telp'];
$no_identitas = $_POST['no_identitas'];
$jenis_identitas = $_POST['jenis_identitas'];

$sql = "UPDATE penyewa SET nama = '$nama', alamat = '$alamat', no_telp = '$no_telp', no_identitas = '$no_identitas', jenis_identitas = '$jenis_identitas' WHERE id_cust = '$id'";
mysqli_query($koneksi, $sql) or die(mysqli_error($koneksi));

header('Location: TampilPenyewa.php');
?>