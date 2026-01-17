<?php
require_once '../auth.php';
include "../koneksi.php";

/* ================== FUNGSI SANITASI ================== */
function bersih($data)
{
    return htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
}

/* ================== AMBIL DATA FORM ================== */
$tipe = bersih($_POST['tipe'] ?? '');
$harga = bersih($_POST['harga_per_mlm'] ?? '');
$max_orang = bersih($_POST['max_orang'] ?? '');

/* ================== PROSES UPLOAD GAMBAR ================== */
if (!isset($_FILES['foto_kamar']) || $_FILES['foto_kamar']['error'] != 0) {
    header('Location: TambahTipeKamar.php?error=foto');
    exit;
}

$namaFile = $_FILES['foto_kamar']['name'];
$tmpFile = $_FILES['foto_kamar']['tmp_name'];
$ext = strtolower(pathinfo($namaFile, PATHINFO_EXTENSION));
$allowedExt = ['jpg', 'jpeg', 'png', 'gif'];

if (!in_array($ext, $allowedExt)) {
    header('Location: TambahTipeKamar.php?error=format');
    exit;
}

$namaFotoBaru = uniqid("foto_") . "." . $ext;
$folderUpload = "uploads/";

// Buat folder jika belum ada
if (!file_exists($folderUpload)) {
    mkdir($folderUpload, 0777, true);
}

if (!move_uploaded_file($tmpFile, $folderUpload . $namaFotoBaru)) {
    header('Location: TambahTipeKamar.php?error=upload');
    exit;
}

/* ================== SIMPAN KE DATABASE ================== */
$sql = "INSERT INTO tipe_kamar (tipe, harga_per_mlm, max_orang, foto) VALUES (?, ?, ?, ?)";

$stmt = $koneksi->prepare($sql);
$stmt->bind_param("sdis", $tipe, $harga, $max_orang, $namaFotoBaru);

if ($stmt->execute()) {
    header('Location: TampilTipeKamar.php');
} else {
    error_log("Error insert tipe kamar: " . mysqli_error($koneksi));
    header('Location: TampilTipeKamar.php?error=1');
}

$stmt->close();
$koneksi->close();
exit;
?>