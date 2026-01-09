<?php
include "../koneksi.php";

$id = $_GET['id'];

// Ambil data user untuk menghapus foto
$result = mysqli_query($koneksi, "SELECT foto FROM users WHERE id = '$id'");
$data = mysqli_fetch_assoc($result);

// Hapus foto jika ada
if (!empty($data['foto']) && file_exists('uploads/' . $data['foto'])) {
    unlink('uploads/' . $data['foto']);
}

$sql = "DELETE FROM users WHERE id = $id";
mysqli_query($koneksi, $sql) or die(mysqli_error($koneksi));

header('Location: TampilUser.php');
?>