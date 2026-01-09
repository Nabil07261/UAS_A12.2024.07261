<?php
include "../koneksi.php";

/* ================== FUNGSI SANITASI ================== */
function bersih($data)
{
    return htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
}

/* ================== AMBIL DATA FORM ================== */
$username = bersih($_POST['username'] ?? '');
$nama = bersih($_POST['nama'] ?? '');
$password = bersih($_POST['password'] ?? '');
$confirm_password = bersih($_POST['confirm_password'] ?? '');

/* ================== VALIDASI PASSWORD ================== */
if ($password !== $confirm_password) {
    die("Password tidak cocok! <a href='TambahUser.php'>Kembali</a>");
}

$hashed_password = password_hash($password, PASSWORD_BCRYPT);

/* ================== PROSES UPLOAD GAMBAR ================== */
if (!isset($_FILES['foto']) || $_FILES['foto']['error'] != 0) {
    die("Upload foto gagal. <a href='TambahUser.php'>Kembali</a>");
}

$namaFile = $_FILES['foto']['name'];
$tmpFile = $_FILES['foto']['tmp_name'];
$ext = strtolower(pathinfo($namaFile, PATHINFO_EXTENSION));
$allowedExt = ['jpg', 'jpeg', 'png', 'gif'];

if (!in_array($ext, $allowedExt)) {
    die("Format gambar tidak diizinkan. <a href='TambahUser.php'>Kembali</a>");
}

$namaFotoBaru = uniqid("foto_") . "." . $ext;
$folderUpload = "uploads/";

if (!move_uploaded_file($tmpFile, $folderUpload . $namaFotoBaru)) {
    die("Gagal menyimpan file gambar. <a href='TambahUser.php'>Kembali</a>");
}

/* ================== SIMPAN KE DATABASE ================== */
$sql = "INSERT INTO users (username, password, nama, foto) VALUES (?, ?, ?, ?)";

$stmt = $koneksi->prepare($sql);
$stmt->bind_param("ssss", $username, $hashed_password, $nama, $namaFotoBaru);

if ($stmt->execute()) {
    header('Location: TampilUser.php');
} else {
    echo "Error: " . mysqli_error($koneksi);
}

$stmt->close();
$koneksi->close();
?>