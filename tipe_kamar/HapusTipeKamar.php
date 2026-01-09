<?php
include "../koneksi.php";

$id = $_GET['id'];

// Ambil data untuk menghapus foto
$result = mysqli_query($koneksi, "SELECT foto FROM tipe_kamar WHERE id_kamar = '$id'");
$data = mysqli_fetch_assoc($result);

// Hapus foto jika ada
if (!empty($data['foto']) && file_exists('uploads/' . $data['foto'])) {
    unlink('uploads/' . $data['foto']);
}

$sql = "DELETE FROM tipe_kamar WHERE id_kamar = '$id'";
mysqli_query($koneksi, $sql) or die(mysqli_error($koneksi));

header('Location: TampilTipeKamar.php');
exit;
?>