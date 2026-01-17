<?php
require_once '../auth.php';
include "../koneksi.php";

/* ================== FUNGSI SANITASI ================== */
function bersih($data)
{
    return htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
}

/* ================== AMBIL DATA FORM ================== */
$id = bersih($_POST['id'] ?? '');
$tipe = bersih($_POST['tipe'] ?? '');
$harga = bersih($_POST['harga_per_mlm'] ?? '');
$max_orang = bersih($_POST['max_orang'] ?? '');
$foto_lama = $_POST['foto_lama'] ?? '';

if (empty($id)) {
    header('Location: TampilTipeKamar.php?error=id');
    exit;
}

/* ================== FOTO ================== */
$xfoto = $foto_lama;

// Jika user upload foto baru
if (!empty($_FILES['foto_kamar']['name'])) {
    $namaFile = $_FILES['foto_kamar']['name'];
    $tmpFile = $_FILES['foto_kamar']['tmp_name'];
    $ext = strtolower(pathinfo($namaFile, PATHINFO_EXTENSION));
    $allowedExt = ['jpg', 'jpeg', 'png', 'gif'];

    if (in_array($ext, $allowedExt)) {
        // Buat folder jika belum ada
        if (!file_exists('uploads')) {
            mkdir('uploads', 0777, true);
        }

        $namaFotoBaru = uniqid("foto_") . "." . $ext;
        move_uploaded_file($tmpFile, "uploads/" . $namaFotoBaru);
        $xfoto = $namaFotoBaru;
    }
}

/* ================== UPDATE DATABASE ================== */
$sql = "UPDATE tipe_kamar SET tipe=?, harga_per_mlm=?, max_orang=?, foto=? WHERE id_kamar=?";
$stmt = $koneksi->prepare($sql);
$stmt->bind_param("sdisi", $tipe, $harga, $max_orang, $xfoto, $id);

if ($stmt->execute()) {
    header('Location: TampilTipeKamar.php');
} else {
    error_log("Error update tipe kamar: " . mysqli_error($koneksi));
    header('Location: TampilTipeKamar.php?error=1');
}

$stmt->close();
$koneksi->close();
exit;
?>