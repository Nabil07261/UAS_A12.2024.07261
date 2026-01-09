<?php
include "../koneksi.php";

$id = $_POST['id'];
$id_cust = $_POST['id_cust'];
$no_kamar = $_POST['no_kamar'];
$tgl_check_in = $_POST['tgl_check_in'];
$tgl_check_out = $_POST['tgl_check_out'];

// Calculate days
$date1 = new DateTime($tgl_check_in);
$date2 = new DateTime($tgl_check_out);
$lama_menginap = $date2->diff($date1)->days;

// Get room price
$result = mysqli_query($koneksi, "SELECT t.harga_per_mlm FROM bedroom b JOIN tipe_kamar t ON b.id_kamar = t.id_kamar WHERE b.no_kamar = '$no_kamar'");
$harga = mysqli_fetch_row($result)[0];

$total_harga = $lama_menginap * $harga;

$sql = "UPDATE menyewa SET id_cust = '$id_cust', no_kamar = '$no_kamar', tgl_check_in = '$tgl_check_in', tgl_check_out = '$tgl_check_out', lama_menginap = '$lama_menginap', total_harga = '$total_harga' WHERE id_sewa = '$id'";
mysqli_query($koneksi, $sql) or die(mysqli_error($koneksi));

header('Location: TampilTransaksi.php');
?>