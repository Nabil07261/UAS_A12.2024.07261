<?php
require_once 'auth.php';
include 'koneksi.php';

// Query statistik overview
$checkin_hari_ini = mysqli_fetch_row(mysqli_query(
    $koneksi,
    "SELECT COUNT(*) FROM menyewa WHERE DATE(tgl_check_in) = CURDATE()"
))[0];
$checkout_hari_ini = mysqli_fetch_row(mysqli_query(
    $koneksi,
    "SELECT COUNT(*) FROM menyewa WHERE DATE(tgl_check_out) = CURDATE()"
))[0];
$total_transaksi = mysqli_fetch_row(mysqli_query(
    $koneksi,
    "SELECT COUNT(*) FROM menyewa"
))[0];
$total_kamar = mysqli_fetch_row(mysqli_query(
    $koneksi,
    "SELECT COUNT(*) FROM bedroom"
))[0];
$total_penyewa = mysqli_fetch_row(mysqli_query(
    $koneksi,
    "SELECT COUNT(*) FROM penyewa"
))[0];

// Query tipe kamar dengan jumlah dan harga
$tipe_kamar = mysqli_query(
    $koneksi,
    "SELECT t.*, COUNT(b.no_kamar) as jumlah_kamar 
     FROM tipe_kamar t 
     LEFT JOIN bedroom b ON t.id_kamar = b.id_kamar 
     GROUP BY t.id_kamar 
     ORDER BY t.tipe"
);

// Data pendapatan per bulan untuk chart
// Data pendapatan per bulan untuk chart (12 bulan terakhir)
$pendapatan_chart = mysqli_query(
    $koneksi,
    "SELECT DATE_FORMAT(tgl_check_in, '%Y-%m') as periode, MONTH(tgl_check_in) as bulan, YEAR(tgl_check_in) as tahun, COALESCE(SUM(total_harga),0) as total 
     FROM menyewa 
     WHERE tgl_check_in >= DATE_SUB(CURDATE(), INTERVAL 11 MONTH)
     GROUP BY YEAR(tgl_check_in), MONTH(tgl_check_in) 
     ORDER BY YEAR(tgl_check_in), MONTH(tgl_check_in)"
);

$bulan_nama = ['', 'Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
$chart_labels = [];
$chart_data = [];
while ($row = mysqli_fetch_assoc($pendapatan_chart)) {
    // Label format: Jan 2025
    $chart_labels[] = $bulan_nama[$row['bulan']] . ' ' . $row['tahun'];
    $chart_data[] = (int) $row['total'];
}

// 5 Transaksi terbaru
$transaksi_terbaru = mysqli_query(
    $koneksi,
    "SELECT m.*, p.nama FROM menyewa m 
     JOIN penyewa p ON m.id_cust = p.id_cust 
     ORDER BY m.id_sewa DESC LIMIT 5"
);

// Pendapatan
$pendapatan_bulan = mysqli_fetch_row(mysqli_query(
    $koneksi,
    "SELECT COALESCE(SUM(total_harga),0) FROM menyewa 
     WHERE MONTH(tgl_check_in) = MONTH(CURDATE())"
))[0];
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <title>Dashboard - Hotel System</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/menu.css">
    <script src="js/chart.js"></script>
</head>

<body>
    <div class="dashboard">
        <!-- Sidebar -->
        <aside class="sidebar">
            <div class="logo">
                <span class="logo-text">Sistem Manajemen Hotel</span>
            </div>

            <ul class="nav-menu">
                <li><a href="menu.php" class="active"><img src="includes/images/dashboard.png" class="nav-icon" alt="">
                        Dashboard</a></li>
                <li><a href="transaksi_baru.php"><img src="includes/images/transaksibaru.png" class="nav-icon" alt="">
                        Front Desk</a></li>
                <li><a href="penyewa/TampilPenyewa.php"><img src="includes/images/penyewa.png" class="nav-icon" alt="">
                        Penyewa</a></li>
                <li><a href="kamar/TampilKamar.php"><img src="includes/images/kamar.png" class="nav-icon" alt="">
                        Kamar</a></li>
                <li><a href="tipe_kamar/TampilTipeKamar.php"><img src="includes/images/tipekamar.png" class="nav-icon"
                            alt=""> Tipe Kamar</a></li>
                <li><a href="transaksi/TampilTransaksi.php"><img src="includes/images/transaksi.png" class="nav-icon"
                            alt=""> Transaksi</a></li>
                <li><a href="user/TampilUser.php"><img src="includes/images/usericon.png" class="nav-icon" alt="">
                        Kelola User</a></li>
            </ul>

            <div class="sidebar-footer">
                <div class="user-card">
                    <div class="user-avatar">
                        <?php if (!empty($_SESSION['foto'])): ?>
                            <img src="user/uploads/<?= htmlspecialchars($_SESSION['foto']) ?>" alt="Avatar"
                                style="width: 40px; height: 40px; border-radius: 50%; object-fit: cover;">
                        <?php else: ?>
                            👤
                        <?php endif; ?>
                    </div>
                    <div class="user-info">
                        <div class="user-name"><?= htmlspecialchars($_SESSION['nama']) ?></div>
                        <div class="user-role">Admin</div>
                    </div>
                    <a href="logout.php" class="logout-link" title="Logout"><img src="includes/images/logout.png"
                            alt="Logout" style="width: 18px; height: 18px;"></a>
                </div>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="main">
            <!-- Header -->
            <header class="header">

                <div class="header-right" style="margin-left: auto;">
                    <span class="date-display"><?= date('l, d F Y') ?></span>
                    <a href="transaksi_baru.php" class="btn-primary">
                        <span>+</span> Transaksi Baru
                    </a>
                </div>
            </header>

            <!-- Content -->
            <div class="content">
                <!-- Overview Section -->
                <h2 class="section-title">Overview</h2>
                <div class="overview-grid">
                    <div class="overview-card">
                        <div class="overview-label">Check-in Hari Ini</div>
                        <div class="overview-value"><?= $checkin_hari_ini ?></div>
                    </div>
                    <div class="overview-card">
                        <div class="overview-label">Check-out Hari Ini</div>
                        <div class="overview-value"><?= $checkout_hari_ini ?></div>
                    </div>
                    <div class="overview-card">
                        <div class="overview-label">Total Transaksi</div>
                        <div class="overview-value"><?= $total_transaksi ?></div>
                    </div>
                    <div class="overview-card">
                        <div class="overview-label">Total Kamar</div>
                        <div class="overview-value"><?= $total_kamar ?></div>
                    </div>
                    <div class="overview-card">
                        <div class="overview-label">Total Penyewa</div>
                        <div class="overview-value"><?= $total_penyewa ?></div>
                    </div>
                </div>

                <!-- Rooms Section -->
                <h2 class="section-title">Kamar</h2>
                <div class="rooms-grid">
                    <?php mysqli_data_seek($tipe_kamar, 0); ?>
                    <?php while ($tipe = mysqli_fetch_assoc($tipe_kamar)): ?>
                        <div class="room-card">
                            <span class="room-badge"><?= $tipe['jumlah_kamar'] ?> Kamar</span>
                            <span class="room-menu">⋮</span>
                            <div class="room-type"><?= htmlspecialchars($tipe['tipe']) ?></div>
                            <div class="room-count"><?= $tipe['jumlah_kamar'] ?><span> / <?= $tipe['max_orang'] ?>
                                    org</span></div>
                            <div class="room-price">Rp <?= number_format($tipe['harga_per_mlm'], 0, ',', '.') ?><span> /
                                    malam</span></div>
                        </div>
                    <?php endwhile; ?>
                </div>

                <!-- Stats & Revenue Row -->
                <div class="grid-2">
                    <!-- Statistics -->
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Statistik</h3>
                        </div>
                        <div class="stats-grid">
                            <div class="stat-group">
                                <h4>Data Kamar</h4>
                                <div class="stat-row">
                                    <span class="stat-label">Total Kamar</span>
                                    <span class="stat-value"><?= $total_kamar ?></span>
                                </div>
                                <div class="stat-row">
                                    <span class="stat-label">Tipe Kamar</span>
                                    <span class="stat-value"><?= mysqli_num_rows($tipe_kamar) ?></span>
                                </div>
                                <div class="stat-row">
                                    <span class="stat-label">Total Penyewa</span>
                                    <span class="stat-value"><?= $total_penyewa ?></span>
                                </div>
                            </div>
                            <div class="stat-group">
                                <h4>Data Transaksi</h4>
                                <div class="stat-row">
                                    <span class="stat-label">Total Transaksi</span>
                                    <span class="stat-value"><?= $total_transaksi ?></span>
                                </div>
                                <div class="stat-row">
                                    <span class="stat-label">Check-in Hari Ini</span>
                                    <span class="stat-value"><?= $checkin_hari_ini ?></span>
                                </div>
                                <div class="stat-row">
                                    <span class="stat-label">Check-out Hari Ini</span>
                                    <span class="stat-value"><?= $checkout_hari_ini ?></span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Revenue -->
                    <div class="card revenue-card">
                        <div class="card-header" style="justify-content: center;">
                            <h3 class="card-title">Pendapatan Bulan Ini</h3>
                        </div>
                        <div class="revenue-amount">Rp <?= number_format($pendapatan_bulan, 0, ',', '.') ?></div>
                        <div class="revenue-label"><?= date('F Y') ?></div>
                    </div>
                </div>

                <!-- Chart & Recent Transactions Row -->
                <div class="grid-2">
                    <!-- Chart -->
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Statistik Pendapatan</h3>
                        </div>
                        <div class="chart-container">
                            <canvas id="revenueChart"></canvas>
                        </div>
                    </div>

                    <!-- Recent Transactions -->
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Transaksi Terbaru</h3>
                            <a href="transaksi/TampilTransaksi.php" class="card-link">Lihat Semua →</a>
                        </div>
                        <?php if (mysqli_num_rows($transaksi_terbaru) > 0): ?>
                            <?php while ($t = mysqli_fetch_assoc($transaksi_terbaru)): ?>
                                <div class="transaction-item">
                                    <div class="transaction-info">
                                        <div class="transaction-avatar">👤</div>
                                        <div>
                                            <div class="transaction-name"><?= htmlspecialchars($t['nama']) ?></div>
                                            <div class="transaction-amount">Rp
                                                <?= number_format($t['total_harga'], 0, ',', '.') ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="transaction-room"><?= $t['no_kamar'] ?></div>
                                </div>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <div class="empty-state">Belum ada transaksi</div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <script>
        const ctx = document.getElementById('revenueChart').getContext('2d');
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: <?= json_encode($chart_labels) ?>,
                datasets: [{
                    label: 'Pendapatan',
                    data: <?= json_encode($chart_data) ?>,
                    backgroundColor: '#2563eb',
                    borderRadius: 8,
                    barThickness: 32
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false }
                },
                scales: {
                    x: {
                        grid: { display: false }
                    },
                    y: {
                        beginAtZero: true,
                        grid: { color: '#f1f5f9' },
                        ticks: {
                            callback: function (value) {
                                if (value >= 1000000) return (value / 1000000) + ' jt';
                                if (value >= 1000) return (value / 1000) + ' rb';
                                return value;
                            }
                        }
                    }
                }
            }
        });
    </script>
</body>

</html>