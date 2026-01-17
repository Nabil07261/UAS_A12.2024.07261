<?php
// Sidebar template for all pages
// Usage: include this file after starting session and getting user info
?>
<aside class="sidebar">
    <div class="logo">
        <span class="logo-text">Sistem Manajemen Hotel</span>
    </div>

    <ul class="nav-menu">
        <li><a href="<?= $base_url ?>menu.php" class="<?= $current_page == 'dashboard' ? 'active' : '' ?>">
                <img src="<?= $base_url ?>includes/images/dashboard.png" class="nav-icon" alt=""> Dashboard</a></li>
        <li><a href="<?= $base_url ?>transaksi_baru.php" class="<?= $current_page == 'front_desk' ? 'active' : '' ?>">
                <img src="<?= $base_url ?>includes/images/transaksibaru.png" class="nav-icon" alt=""> Front Desk</a>
        </li>
        <li><a href="<?= $base_url ?>penyewa/TampilPenyewa.php"
                class="<?= $current_page == 'penyewa' ? 'active' : '' ?>">
                <img src="<?= $base_url ?>includes/images/penyewa.png" class="nav-icon" alt=""> Penyewa</a></li>
        <li><a href="<?= $base_url ?>kamar/TampilKamar.php" class="<?= $current_page == 'kamar' ? 'active' : '' ?>">
                <img src="<?= $base_url ?>includes/images/kamar.png" class="nav-icon" alt=""> Kamar</a></li>
        <li><a href="<?= $base_url ?>tipe_kamar/TampilTipeKamar.php"
                class="<?= $current_page == 'tipe_kamar' ? 'active' : '' ?>">
                <img src="<?= $base_url ?>includes/images/tipekamar.png" class="nav-icon" alt=""> Tipe Kamar</a></li>
        <li><a href="<?= $base_url ?>transaksi/TampilTransaksi.php"
                class="<?= $current_page == 'transaksi' ? 'active' : '' ?>">
                <img src="<?= $base_url ?>includes/images/transaksi.png" class="nav-icon" alt=""> Transaksi</a></li>
        <li><a href="<?= $base_url ?>user/TampilUser.php" class="<?= $current_page == 'user' ? 'active' : '' ?>">
                <img src="<?= $base_url ?>includes/images/usericon.png" class="nav-icon" alt=""> Kelola User</a></li>
    </ul>

    <div class="sidebar-footer">
        <div class="user-card">
            <div class="user-avatar">
                <?php if (!empty($_SESSION['foto'])): ?>
                    <img src="<?= $base_url ?>user/uploads/<?= htmlspecialchars($_SESSION['foto']) ?>" alt="Avatar"
                        style="width: 40px; height: 40px; border-radius: 50%; object-fit: cover;">
                <?php else: ?>
                    👤
                <?php endif; ?>
            </div>
            <div class="user-info">
                <div class="user-name">
                    <?= htmlspecialchars($_SESSION['nama'] ?? 'User') ?>
                </div>
                <div class="user-role">Admin</div>
            </div>
            <a href="<?= $base_url ?>logout.php" class="logout-link" title="Logout"><img
                    src="<?= $base_url ?>includes/images/logout.png" alt="Logout"
                    style="width: 18px; height: 18px;"></a>
        </div>
    </div>
</aside>

<style>
    .nav-icon {
        width: 20px;
        height: 20px;
        object-fit: contain;
        margin-right: 12px;
        vertical-align: middle;
    }
</style>