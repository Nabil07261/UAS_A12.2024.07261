<?php
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
if (!isset($_FILES['foto']) || $_FILES['foto']['error'] != 0) {
    die("Upload foto gagal. <a href='TambahTipeKamar.php'>Kembali</a>");
}

$namaFile = $_FILES['foto']['name'];
$tmpFile = $_FILES['foto']['tmp_name'];
$ext = strtolower(pathinfo($namaFile, PATHINFO_EXTENSION));
$allowedExt = ['jpg', 'jpeg', 'png', 'gif'];

if (!in_array($ext, $allowedExt)) {
    die("Format gambar tidak diizinkan. <a href='TambahTipeKamar.php'>Kembali</a>");
}

$namaFotoBaru = uniqid("foto_") . "." . $ext;
$folderUpload = "uploads/";

// Buat folder jika belum ada
if (!file_exists($folderUpload)) {
    mkdir($folderUpload, 0777, true);
}

if (!move_uploaded_file($tmpFile, $folderUpload . $namaFotoBaru)) {
    die("Gagal menyimpan file gambar. <a href='TambahTipeKamar.php'>Kembali</a>");
}

/* ================== SIMPAN KE DATABASE ================== */
$sql = "INSERT INTO tipe_kamar (tipe, harga_per_mlm, max_orang, foto) VALUES (?, ?, ?, ?)";

$stmt = $koneksi->prepare($sql);
$stmt->bind_param("sdis", $tipe, $harga, $max_orang, $namaFotoBaru);

if ($stmt->execute()) {
    header('Location: TampilTipeKamar.php');
} else {
    echo "Error: " . mysqli_error($koneksi);
}

$stmt->close();
$koneksi->close();
?>