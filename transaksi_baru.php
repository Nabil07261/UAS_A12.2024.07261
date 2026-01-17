<?php
require_once 'auth.php';
include 'koneksi.php';

$base_url = '';
$current_page = 'front_desk';
$today = date('Y-m-d');

$kamar_result = mysqli_query($koneksi, "SELECT b.no_kamar, t.tipe, t.harga_per_mlm FROM bedroom b JOIN tipe_kamar t ON b.id_kamar = t.id_kamar ORDER BY b.no_kamar");
$penyewa_result = mysqli_query($koneksi, "SELECT * FROM penyewa ORDER BY nama");

$error = isset($_SESSION['transaksi_error']) ? $_SESSION['transaksi_error'] : '';
$success = isset($_SESSION['transaksi_success']) ? $_SESSION['transaksi_success'] : '';
unset($_SESSION['transaksi_error'], $_SESSION['transaksi_success']);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <title>Transaksi Baru - Hotel System</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/dashboard.css">
    <style>
        .room-status {
            display: inline-block;
            padding: 2px 8px;
            border-radius: 4px;
            font-size: 11px;
            font-weight: 600;
            margin-left: 8px;
        }
        .room-available {
            background: #dcfce7;
            color: #16a34a;
        }
        .room-booked {
            background: #fee2e2;
            color: #dc2626;
        }
        .room-card-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 12px;
            max-height: 300px;
            overflow-y: auto;
            padding: 12px;
            background: #f8fafc;
            border-radius: 8px;
            margin-top: 12px;
        }
        .room-select-card {
            padding: 12px;
            border: 2px solid #e2e8f0;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.2s;
            background: white;
        }
        .room-select-card:hover {
            border-color: #2563eb;
        }
        .room-select-card.selected {
            border-color: #2563eb;
            background: #eff6ff;
        }
        .room-select-card.disabled {
            opacity: 0.5;
            cursor: not-allowed;
            background: #f1f5f9;
        }
        .room-select-card .room-no {
            font-size: 18px;
            font-weight: 700;
            color: #1e293b;
        }
        .room-select-card .room-type {
            font-size: 12px;
            color: #64748b;
        }
        .room-select-card .room-price {
            font-size: 13px;
            color: #2563eb;
            font-weight: 600;
            margin-top: 4px;
        }
        .date-picker-hint {
            padding: 20px;
            text-align: center;
            color: #64748b;
            background: #f8fafc;
            border-radius: 8px;
            margin-top: 12px;
        }
        .legend {
            display: flex;
            gap: 16px;
            margin-top: 12px;
            font-size: 12px;
        }
        .legend-item {
            display: flex;
            align-items: center;
            gap: 6px;
        }
        .legend-dot {
            width: 12px;
            height: 12px;
            border-radius: 50%;
        }
        .legend-dot.available { background: #22c55e; }
        .legend-dot.booked { background: #ef4444; }
    </style>
</head>
<body>
    <div class="dashboard">
        <?php include 'includes/sidebar.php'; ?>

        <main class="main">
            <header class="header">
                <h1 class="page-title">Front Desk - Transaksi Baru</h1>
            </header>

            <div class="content">
                <?php if ($error): ?>
                <div class="alert alert-danger"><?= $error ?></div>
                <?php endif; ?>
                <?php if ($success): ?>
                <div class="alert alert-success"><?= $success ?></div>
                <?php endif; ?>

                <form action="SimpanTransaksiBaru.php" method="POST" id="formTransaksiBaru">
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 24px;">
                        <!-- Data Penyewa -->
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Data Penyewa</h3>
                            </div>
                            
                            <div class="form-group">
                                <label class="form-label">Tipe Penyewa</label>
                                <div style="display: flex; gap: 20px;">
                                    <label><input type="radio" name="tipe_penyewa" value="baru" id="penyewa_baru" checked onclick="togglePenyewa()"> Penyewa Baru</label>
                                    <label><input type="radio" name="tipe_penyewa" value="existing" id="penyewa_existing" onclick="togglePenyewa()"> Penyewa Terdaftar</label>
                                </div>
                            </div>

                            <div id="form_baru">
                                <div class="form-group">
                                    <label class="form-label">Nama Lengkap</label>
                                    <input type="text" name="nama" id="nama" class="form-control" minlength="3" placeholder="Masukkan nama">
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Alamat</label>
                                    <textarea name="alamat" id="alamat" class="form-control" rows="2" placeholder="Masukkan alamat"></textarea>
                                </div>
                                <div class="form-group">
                                    <label class="form-label">No Telepon</label>
                                    <input type="tel" name="no_telp" id="no_telp" class="form-control" pattern="[0-9]{10,13}" placeholder="081234567890">
                                </div>
                                <div class="form-group">
                                    <label class="form-label">No Identitas</label>
                                    <input type="text" name="no_identitas" id="no_identitas" class="form-control" minlength="16" maxlength="16" placeholder="16 digit">
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Jenis Identitas</label>
                                    <select name="jenis_identitas" class="form-control">
                                        <option value="KTP">KTP</option>
                                        <option value="SIM">SIM</option>
                                        <option value="Paspor">Paspor</option>
                                    </select>
                                </div>
                            </div>

                            <div id="form_existing" style="display:none;">
                                <div class="form-group">
                                    <label class="form-label">Pilih Penyewa</label>
                                    <select name="id_cust" id="id_cust" class="form-control">
                                        <option value="">-- Pilih Penyewa --</option>
                                        <?php while ($p = mysqli_fetch_assoc($penyewa_result)): ?>
                                        <option value="<?= $p['id_cust'] ?>"><?= htmlspecialchars($p['nama']) ?> (<?= $p['no_identitas'] ?>)</option>
                                        <?php endwhile; ?>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- Data Booking -->
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Data Booking</h3>
                            </div>
                            
                            <div class="form-group">
                                <label class="form-label">Tanggal Check In</label>
                                <input type="date" name="tgl_check_in" id="tgl_check_in" class="form-control" required min="<?= $today ?>">
                            </div>
                            
                            <div class="form-group">
                                <label class="form-label">Tanggal Check Out</label>
                                <input type="date" name="tgl_check_out" id="tgl_check_out" class="form-control" required min="<?= $today ?>">
                            </div>

                            <div class="form-group">
                                <label class="form-label">Pilih Kamar</label>
                                <input type="hidden" name="no_kamar" id="selected_room" required>
                                
                                <div id="room-container">
                                    <div class="date-picker-hint">
                                        Pilih tanggal Check In dan Check Out untuk melihat ketersediaan kamar
                                    </div>
                                </div>

                                <div class="legend">
                                    <div class="legend-item"><div class="legend-dot available"></div> Tersedia</div>
                                    <div class="legend-item"><div class="legend-dot booked"></div> Terisi</div>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary" style="width: 100%; margin-top: 20px;" id="btnSubmit" disabled>
                                Simpan Transaksi
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </main>
    </div>

    <script>
        function togglePenyewa() {
            var isBaru = document.getElementById('penyewa_baru').checked;
            document.getElementById('form_baru').style.display = isBaru ? 'block' : 'none';
            document.getElementById('form_existing').style.display = isBaru ? 'none' : 'block';
            
            document.getElementById('nama').required = isBaru;
            document.getElementById('no_identitas').required = isBaru;
            document.getElementById('no_telp').required = isBaru;
            document.getElementById('id_cust').required = !isBaru;
        }

        function checkRoomAvailability() {
            var checkIn = document.getElementById('tgl_check_in').value;
            var checkOut = document.getElementById('tgl_check_out').value;
            
            if (!checkIn || !checkOut) return;
            if (checkOut <= checkIn) return;
            
            // Reset selected room
            document.getElementById('selected_room').value = '';
            document.getElementById('btnSubmit').disabled = true;
            
            // Fetch room availability
            fetch('api_cek_kamar.php?check_in=' + checkIn + '&check_out=' + checkOut)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        renderRooms(data.rooms);
                    }
                })
                .catch(error => console.error('Error:', error));
        }

        function renderRooms(rooms) {
            var container = document.getElementById('room-container');
            var html = '<div class="room-card-grid">';
            
            rooms.forEach(function(room) {
                var statusClass = room.available ? '' : 'disabled';
                var statusBadge = room.available 
                    ? '<span class="room-status room-available">Tersedia</span>' 
                    : '<span class="room-status room-booked">Terisi</span>';
                
                html += '<div class="room-select-card ' + statusClass + '" ' +
                        (room.available ? 'onclick="selectRoom(\'' + room.no_kamar + '\', this)"' : '') + '>' +
                        '<div class="room-no">Kamar ' + room.no_kamar + statusBadge + '</div>' +
                        '<div class="room-type">' + room.tipe + '</div>' +
                        '<div class="room-price">Rp ' + room.harga_format + '/malam</div>' +
                        '</div>';
            });
            
            html += '</div>';
            container.innerHTML = html;
        }

        function selectRoom(noKamar, element) {
            // Remove previous selection
            document.querySelectorAll('.room-select-card').forEach(function(card) {
                card.classList.remove('selected');
            });
            
            // Select this room
            element.classList.add('selected');
            document.getElementById('selected_room').value = noKamar;
            document.getElementById('btnSubmit').disabled = false;
        }

        document.getElementById('tgl_check_in').addEventListener('change', function() {
            var checkOut = document.getElementById('tgl_check_out');
            var nextDay = new Date(this.value);
            nextDay.setDate(nextDay.getDate() + 1);
            checkOut.min = nextDay.toISOString().split('T')[0];
            if (checkOut.value && checkOut.value <= this.value) checkOut.value = '';
            
            checkRoomAvailability();
        });

        document.getElementById('tgl_check_out').addEventListener('change', function() {
            checkRoomAvailability();
        });

        document.getElementById('formTransaksiBaru').addEventListener('submit', function(e) {
            var checkIn = document.getElementById('tgl_check_in').value;
            var checkOut = document.getElementById('tgl_check_out').value;
            var selectedRoom = document.getElementById('selected_room').value;
            
            if (checkOut <= checkIn) {
                alert('Tanggal Check Out harus setelah Check In!');
                e.preventDefault();
                return;
            }
            
            if (!selectedRoom) {
                alert('Pilih kamar terlebih dahulu!');
                e.preventDefault();
                return;
            }
        });

        togglePenyewa();
    </script>
</body>
</html>