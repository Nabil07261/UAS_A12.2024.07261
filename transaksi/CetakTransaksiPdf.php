<?php
require __DIR__ . '/fpdf186/fpdf.php';
require '../koneksi.php';

// Membuat kelas turunan FPDF untuk menambahkan footer 
class PDF extends FPDF
{
    // Footer untuk menambahkan nomor halaman
    function Footer()
    {
        // Set posisi 1.5 cm dari bawah 
        $this->SetY(-15);

        // Set font untuk footer 
        $this->SetFont('Arial', 'I', 10);

        // Nomor halaman 
        $this->Cell(0, 10, 'Halaman ' . $this->PageNo(), 0, 0, 'C');
    }
}

// Query untuk mengambil data transaksi
$sql = "SELECT m.*, p.nama, b.no_kamar as kamar, t.tipe 
        FROM menyewa m 
        JOIN penyewa p ON m.id_cust = p.id_cust 
        JOIN bedroom b ON m.no_kamar = b.no_kamar 
        JOIN tipe_kamar t ON b.id_kamar = t.id_kamar
        ORDER BY m.id_sewa DESC";
$result = mysqli_query($koneksi, $sql);

// Membuat objek PDF dengan orientasi Landscape
$pdf = new PDF('L', 'mm', 'A4');
$pdf->AddPage();

// Set Font untuk judul
$pdf->SetFont('Arial', 'B', 16);
$pdf->Cell(277, 10, 'Laporan Data Transaksi Sewa Kamar Hotel', 0, 1, 'C');

// Tanggal cetak
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(277, 10, 'Tanggal Cetak: ' . date('d-m-Y H:i:s'), 0, 1, 'C');

// Memberikan jarak sebelum tabel 
$pdf->Ln(5);

// Set header tabel dengan warna latar belakang 
$pdf->SetFillColor(230, 230, 230); // Warna latar belakang header (light gray) 
$pdf->SetFont('Arial', 'B', 10);

// Header tabel
$pdf->Cell(10, 10, 'No', 1, 0, 'C', 1);
$pdf->Cell(45, 10, 'Nama Penyewa', 1, 0, 'C', 1);
$pdf->Cell(25, 10, 'No Kamar', 1, 0, 'C', 1);
$pdf->Cell(30, 10, 'Tipe Kamar', 1, 0, 'C', 1);
$pdf->Cell(30, 10, 'Check In', 1, 0, 'C', 1);
$pdf->Cell(30, 10, 'Check Out', 1, 0, 'C', 1);
$pdf->Cell(25, 10, 'Lama (mlm)', 1, 0, 'C', 1);
$pdf->Cell(40, 10, 'Total Harga', 1, 1, 'C', 1);

// Menampilkan data transaksi
$pdf->SetFont('Arial', '', 10);
$no = 1;
$grandTotal = 0;

while ($row = mysqli_fetch_assoc($result)) {
    $pdf->Cell(10, 8, $no, 1, 0, 'C');
    $pdf->Cell(45, 8, $row['nama'], 1, 0, 'L');
    $pdf->Cell(25, 8, $row['kamar'], 1, 0, 'C');
    $pdf->Cell(30, 8, $row['tipe'], 1, 0, 'C');
    $pdf->Cell(30, 8, $row['tgl_check_in'], 1, 0, 'C');
    $pdf->Cell(30, 8, $row['tgl_check_out'], 1, 0, 'C');
    $pdf->Cell(25, 8, $row['lama_menginap'], 1, 0, 'C');
    $pdf->Cell(40, 8, 'Rp ' . number_format($row['total_harga'], 0, ',', '.'), 1, 1, 'R');
    $grandTotal += $row['total_harga'];
    $no++;
}

// Grand Total
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(195, 10, 'GRAND TOTAL', 1, 0, 'R', 1);
$pdf->Cell(40, 10, 'Rp ' . number_format($grandTotal, 0, ',', '.'), 1, 1, 'R', 1);

// Output PDF 
$pdf->Output();
?>