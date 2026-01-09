<?php
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
    die("ERROR: ID tidak ditemukan");
}

/* ================== FOTO ================== */
$xfoto = $foto_lama;

// Jika user upload foto baru
if (!empty($_FILES['foto']['name'])) {
    $namaFile = $_FILES['foto']['name'];
    $tmpFile = $_FILES['foto']['tmp_name'];
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
    echo "Error: " . mysqli_error($koneksi);
}

$stmt->close();
$koneksi->close();
?>