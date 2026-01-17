<?php
// API endpoint untuk cek ketersediaan kamar berdasarkan tanggal
require_once 'auth.php';
include 'koneksi.php';

header('Content-Type: application/json');

$tgl_check_in = $_GET['check_in'] ?? '';
$tgl_check_out = $_GET['check_out'] ?? '';

if (empty($tgl_check_in) || empty($tgl_check_out)) {
    echo json_encode(['error' => 'Tanggal tidak valid']);
    exit;
}

// Query semua kamar dengan info tipe dan harga
$sql = "SELECT b.no_kamar, t.tipe, t.harga_per_mlm FROM bedroom b 
        JOIN tipe_kamar t ON b.id_kamar = t.id_kamar 
        ORDER BY b.no_kamar";
$kamar_result = mysqli_query($koneksi, $sql);

// Query kamar yang sudah dipesan di tanggal tersebut
$sql_booked = "SELECT DISTINCT no_kamar FROM menyewa 
               WHERE tgl_check_in < ? AND tgl_check_out > ?";
$stmt = mysqli_prepare($koneksi, $sql_booked);
mysqli_stmt_bind_param($stmt, "ss", $tgl_check_out, $tgl_check_in);
mysqli_stmt_execute($stmt);
$result_booked = mysqli_stmt_get_result($stmt);

$booked_rooms = [];
while ($row = mysqli_fetch_assoc($result_booked)) {
    $booked_rooms[] = $row['no_kamar'];
}
mysqli_stmt_close($stmt);

// Buat response dengan status ketersediaan
$rooms = [];
while ($k = mysqli_fetch_assoc($kamar_result)) {
    $is_available = !in_array($k['no_kamar'], $booked_rooms);
    $rooms[] = [
        'no_kamar' => $k['no_kamar'],
        'tipe' => $k['tipe'],
        'harga' => $k['harga_per_mlm'],
        'harga_format' => number_format($k['harga_per_mlm'], 0, ',', '.'),
        'available' => $is_available
    ];
}

echo json_encode([
    'success' => true,
    'rooms' => $rooms,
    'check_in' => $tgl_check_in,
    'check_out' => $tgl_check_out
]);
?>