<?php
require_once '../auth.php';
include "../koneksi.php";

$id = $_GET['id'] ?? '';

if (empty($id)) {
    header('Location: TampilTipeKamar.php');
    exit;
}

// Ambil data untuk menghapus foto dengan prepared statement
$sql_foto = "SELECT foto FROM tipe_kamar WHERE id_kamar = ?";
$stmt_foto = mysqli_prepare($koneksi, $sql_foto);
mysqli_stmt_bind_param($stmt_foto, "i", $id);
mysqli_stmt_execute($stmt_foto);
$result = mysqli_stmt_get_result($stmt_foto);
$data = mysqli_fetch_assoc($result);
mysqli_stmt_close($stmt_foto);

// Hapus foto jika ada
if (!empty($data['foto']) && file_exists('uploads/' . $data['foto'])) {
    unlink('uploads/' . $data['foto']);
}

// Hapus dari database dengan prepared statement
$sql = "DELETE FROM tipe_kamar WHERE id_kamar = ?";
$stmt = mysqli_prepare($koneksi, $sql);
mysqli_stmt_bind_param($stmt, "i", $id);

if (mysqli_stmt_execute($stmt)) {
    header('Location: TampilTipeKamar.php');
} else {
    error_log("Error hapus tipe kamar: " . mysqli_error($koneksi));
    header('Location: TampilTipeKamar.php?error=1');
}

mysqli_stmt_close($stmt);
exit;
?>