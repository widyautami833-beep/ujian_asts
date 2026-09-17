
<?php
session_start();

if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit;
}

include "koneksi.php";

$total = mysqli_fetch_assoc(
    mysqli_query($koneksi, "SELECT COUNT(*) AS jumlah FROM users")
)['jumlah'];

$male = mysqli_fetch_assoc(
    mysqli_query($koneksi, "SELECT COUNT(*) AS jumlah FROM users WHERE gender='MALE'")
)['jumlah'];

$female = mysqli_fetch_assoc(
    mysqli_query($koneksi, "SELECT COUNT(*) AS jumlah FROM users WHERE gender='FEMALE'")
)['jumlah'];

$malePercent = $total > 0 ? round(($male / $total) * 100) : 0;
$femalePercent = $total > 0 ? round(($female / $total) * 100) : 0;

$aktivitas = mysqli_query(
    $koneksi,
    "SELECT * FROM users ORDER BY id DESC LIMIT 5"
);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - UJIAN ASTS</title>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        body {
            background: #f2f6fc;
            color: #173f70;
        }

        .layout {
            display: flex;
            min-height: 100vh;
        }

        .sidebar {
            width: 235px;
            background: white;
            padding: 28px 18px;
            border-right: 1px solid #e1eaf5;
        }

        .logo {
            text-align: center;
            margin-bottom: 42px;
        }

        .logo h2 {
            color: #164477;
            font-size: 21px;
        }

        .logo p {
            color: #91a4bc;
            font-size: 11px;
            margin-top: 8px;
        }

        .menu-title {
            color: #8ca0b8;
            font-size: 11px;
            font-weight: bold;
            letter-spacing: 1px;
            margin: 25px 0 12px;
        }

        .menu a {
            display: block;
            text-decoration: none;
            color: #466789;
            padding: 13px 12px;
            border-radius: 10px;
            margin-bottom: 8px;
            font-size: 14px;
        }

        .menu a:hover,
        .menu a.active {
            background: #e4effc;
            color: #14569c;
        }

        .content {
            flex: 1;
            padding: 35px;
            max-width: 1250px;
        }

        .welcome {
            background: linear-gradient(135deg, #eaf4ff, #f8fbff);
            border: 1px solid #dceafa;
            border-radius: 18px;
            padding: 28px;
            margin-bottom: 25px;
        }

        .welcome h1 {
            font-size: 26px;
            margin-bottom: 10px;
        }

        .welcome p {
            color: #7890ac;
            font-size: 14px;
        }

        .clock {
            margin-top: 18px;
            font-size: 14px;
            color: #4777a9;
            font-weight: bold;
        }

        .stats {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
            margin-bottom: 25px;
        }

        .stat-card {
            background: white;
            padding: 24px;
            border-radius: 17px;
            border: 1px solid #e2ebf6;
            box-shadow: 0 6px 20px rgba(48, 91, 132, 0.06);
        }

        .stat-card .label {
            color: #7890ac;
            font-size: 13px;
            margin-bottom: 15px;
        }

        .stat-card h2 {
            color: #164477;
            font-size: 34px;
            margin-bottom: 10px;
        }

        .stat-card p {
            color: #91a4bc;
            font-size: 12px;
        }

        .stat-card.blue {
            border-top: 4px solid #5796dc;
        }

        .stat-card.green {
            border-top: 4px solid #72b99a;
        }

        .stat-card.pink {
            border-top: 4px solid #d99bb8;
        }

        .main-grid {
            display: grid;
            grid-template-columns: 1.3fr 1fr;
            gap: 22px;
        }

        .panel {
            background: white;
            padding: 25px;
            border-radius: 17px;
            border: 1px solid #e2ebf6;
            box-shadow: 0 6px 20px rgba(48, 91, 132, 0.05);
        }

        .panel h2 {
            font-size: 19px;
            margin-bottom: 20px;
        }

        .activity {
            padding: 14px 0;
            border-bottom: 1px solid #edf2f8;
        }

        .activity:last-child {
            border-bottom: none;
        }

        .activity strong {
            font-size: 14px;
            color: #234f7d;
        }

        .activity p {
            color: #91a4bc;
            font-size: 12px;
            margin-top: 6px;
        }

        .gender {
            margin-bottom: 23px;
        }

        .gender-header {
            display: flex;
            justify-content: space-between;
            font-size: 13px;
            margin-bottom: 9px;
        }

        .progress {
            height: 9px;
            background: #edf3f9;
            border-radius: 20px;
            overflow: hidden;
        }

        .progress-bar {
            height: 100%;
            width: 0;
            border-radius: 20px;
            transition: width 1.2s ease;
        }

        .male-bar {
            background: #619dde;
        }

        .female-bar {
            background: #d99bb8;
        }

        .quick-actions {
            margin-top: 22px;
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }

        .quick-actions a {
            text-decoration: none;
            padding: 11px 15px;
            border-radius: 9px;
            background: #e5f0fd;
            color: #28639c;
            font-size: 12px;
        }

        @media (max-width: 900px) {
            .stats,
            .main-grid {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 650px) {
            .layout {
                display: block;
            }

            .sidebar {
                width: 100%;
            }

            .content {
                padding: 20px;
            }
        }

        .logout-btn {
    margin-top: 35px !important;
    background: #fff0f2 !important;
    color: #d4778b !important;
    border: 1px solid #f8dce2;
    transition: 0.3s;
}

.logout-btn:hover {
    background: #fce0e6 !important;
    color: #c45b73 !important;
}

.logout-btn span {
    margin-right: 8px;
    font-size: 16px;
}
    </style>
</head>

<body>

<div class="layout">

    <aside class="sidebar">
        <div class="logo">
            <h2>UJIAN ASTS</h2>
            <p>Student Management</p>
        </div>

        <div class="menu-title">MENU UTAMA</div>

        <div class="menu">
            <a href="dashboard.php" class="active">⌂ Dashboard</a>
            <a href="index.php">♙ Data Users</a>
            <a href="form.php">＋ Tambah Data</a>
        </div>

        <div class="menu-title">DATA</div>

        <div class="menu">
            <a href="data_json.php">｛ ｝ JSON API</a>
        </div>

        <a href="logout.php">↪ Logout</a>

    </aside>

    <main class="content">

        <section class="welcome">
            <h1>Dashboard Ujian ASTS</h1>
            <p>Selamat datang, <?= $_SESSION['admin'] ?? 'Admin' ?>. Kelola data siswa dengan mudah.</p>
            <div class="clock" id="clock">Memuat waktu...</div>
        </section>

        <section class="stats">

            <div class="stat-card blue">
                <div class="label">TOTAL SISWA</div>
                <h2 class="counter" data-target="<?= $total ?>">0</h2>
                <p>Data seluruh siswa</p>
            </div>

            <div class="stat-card green">
                <div class="label">LAKI-LAKI</div>
                <h2 class="counter" data-target="<?= $male ?>">0</h2>
                <p><?= $malePercent ?>% dari total data</p>
            </div>

            <div class="stat-card pink">
                <div class="label">PEREMPUAN</div>
                <h2 class="counter" data-target="<?= $female ?>">0</h2>
                <p><?= $femalePercent ?>% dari total data</p>
            </div>

        </section>

        <section class="main-grid">

            <div class="panel">
                <h2>Aktivitas Terbaru</h2>

                <?php while ($row = mysqli_fetch_assoc($aktivitas)) : ?>
                    <div class="activity">
                        <strong>♙ <?= htmlspecialchars($row['name']) ?></strong>
                        <p>Data siswa terdaftar</p>
                    </div>
                <?php endwhile; ?>

                <div class="quick-actions">
                    <a href="index.php">Lihat Semua</a>
                    <a href="form.php">Tambah Data</a>
                </div>
            </div>

            <div class="panel">
                <h2>Statistik Gender</h2>

                <div class="gender">
                    <div class="gender-header">
                        <span>Laki-laki</span>
                        <span><?= $malePercent ?>%</span>
                    </div>

                    <div class="progress">
                        <div class="progress-bar male-bar"
                             data-width="<?= $malePercent ?>"></div>
                    </div>
                </div>

                <div class="gender">
                    <div class="gender-header">
                        <span>Perempuan</span>
                        <span><?= $femalePercent ?>%</span>
                    </div>

                    <div class="progress">
                        <div class="progress-bar female-bar"
                             data-width="<?= $femalePercent ?>"></div>
                    </div>
                </div>
            </div>

        </section>

    </main>
</div>

<script>
    // Jam digital
    function updateClock() {
        const now = new Date();

        const time = now.toLocaleTimeString('id-ID', {
            hour: '2-digit',
            minute: '2-digit',
            second: '2-digit'
        });

        document.getElementById('clock').textContent =
            'Waktu sekarang: ' + time;
    }

    updateClock();
    setInterval(updateClock, 1000);


    // Animasi angka statistik
    const counters = document.querySelectorAll('.counter');

    counters.forEach(counter => {
        const target = Number(counter.dataset.target);
        let current = 0;

        function animateCounter() {
            const increment = Math.max(1, Math.ceil(target / 50));

            if (current < target) {
                current += increment;

                if (current > target) {
                    current = target;
                }

                counter.textContent = current;
                requestAnimationFrame(animateCounter);
            } else {
                counter.textContent = target;
            }
        }

        animateCounter();
    });


    // Animasi progress bar
    const progressBars = document.querySelectorAll('.progress-bar');

    setTimeout(() => {
        progressBars.forEach(bar => {
            bar.style.width = bar.dataset.width + '%';
        });
    }, 300);
</script>

</body>
</html>