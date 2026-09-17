<?php

include "koneksi.php";

// ================= PAGINATION =================

$batas = 5;

$halaman = isset($_GET['halaman'])
    ? (int) $_GET['halaman']
    : 1;

if ($halaman < 1) {
    $halaman = 1;
}

// Total data
$query_total = mysqli_query(
    $koneksi,
    "SELECT COUNT(*) AS total FROM users"
);

$data_total = mysqli_fetch_assoc($query_total);
$total_data = (int) $data_total['total'];

// Total halaman
$total_halaman = max(
    1,
    (int) ceil($total_data / $batas)
);

if ($halaman > $total_halaman) {
    $halaman = $total_halaman;
}

// Posisi data
$posisi = ($halaman - 1) * $batas;

// Query data dengan pagination
$data = mysqli_query(
    $koneksi,
    "SELECT * FROM users
     ORDER BY id ASC
     LIMIT $posisi, $batas"
);

?>

<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Data Users - Ujian ASTS</title>

    <link rel="stylesheet" href="style.css">

</head>

<body>

<aside class="sidebar">

    <div class="logo">
        UJIAN ASTS
        <small>Student Management</small>
    </div>

    <div class="menu-title">
        MENU UTAMA
    </div>

    <a href="dashboard.php" class="menu">
        <span>⌂</span> Dashboard
    </a>

    <a href="index.php" class="menu active">
        <span>♙</span> Data Users
    </a>

    <a href="form.php" class="menu">
        <span>＋</span> Tambah Data
    </a>

    <div class="menu-title">
        DATA
    </div>

    <a href="data_json.php" class="menu">
        <span>{ }</span> JSON API
    </a>

</aside>


<main class="main">

    <div class="container">

        <div class="header">

            <h1>♙ Data Users - Ujian ASTS</h1>

            <p>
                Kelola data siswa dengan mudah dan cepat
            </p>

        </div>


        <a href="form.php" class="tambah">
            ＋ Tambah Data
        </a>


        <div class="data-info">

            Menampilkan
            <?= $total_data > 0 ? $posisi + 1 : 0; ?>
            -
            <?= min($posisi + $batas, $total_data); ?>

            dari <?= $total_data; ?> data siswa

        </div>


        <div class="table-box">

            <table>

                <thead>

                    <tr>
                        <th>NO / ID</th>
                        <th>NAMA</th>
                        <th>NISN</th>
                        <th>TTL</th>
                        <th>GENDER</th>
                        <th>EMAIL</th>
                        <th>ALAMAT</th>
                        <th>AKSI</th>
                    </tr>

                </thead>

                <tbody>

                <?php if (mysqli_num_rows($data) > 0) : ?>

                    <?php while ($row = mysqli_fetch_assoc($data)) : ?>

                        <tr>

                            <td class="center id">
                                <?= htmlspecialchars($row['id']); ?>
                            </td>

                            <td>
                                <?= htmlspecialchars($row['name']); ?>
                            </td>

                            <td>
                                <?= htmlspecialchars($row['nisn'] ?? ''); ?>
                            </td>

                            <td>
                                <?= htmlspecialchars($row['ttl'] ?? ''); ?>
                            </td>

                            <td>
                                <span class="gender">
                                    <?= htmlspecialchars($row['gender'] ?? ''); ?>
                                </span>
                            </td>

                            <td>
                                <?= htmlspecialchars($row['email'] ?? ''); ?>
                            </td>

                            <td>
                                <?= htmlspecialchars($row['address'] ?? ''); ?>
                            </td>

                            <td class="center">

                                <a
                                    href="form.php?id=<?= $row['id']; ?>"
                                    class="btn-edit"
                                >
                                    Edit
                                </a>

                                <a
                                    href="hapus.php?id=<?= $row['id']; ?>"
                                    class="btn-hapus"
                                    onclick="return confirm('Yakin ingin menghapus data ini?')"
                                >
                                    Hapus
                                </a>

                            </td>

                        </tr>

                    <?php endwhile; ?>

                <?php else : ?>

                    <tr>

                        <td colspan="8" class="empty-data">
                            Belum ada data siswa.
                        </td>

                    </tr>

                <?php endif; ?>

                </tbody>

            </table>

        </div>


        <!-- PAGINATION -->

        <div class="pagination-area">

            <div class="pagination-info">

                Halaman <?= $halaman; ?>
                dari <?= $total_halaman; ?>

            </div>


            <div class="pagination">

                <?php if ($halaman > 1) : ?>

                    <a href="?halaman=<?= $halaman - 1; ?>">
                        ‹
                    </a>

                <?php else : ?>

                    <span class="disabled">‹</span>

                <?php endif; ?>


                <?php for ($i = 1; $i <= $total_halaman; $i++) : ?>

                    <a
                        href="?halaman=<?= $i; ?>"
                        class="<?= ($i == $halaman) ? 'active' : ''; ?>"
                    >
                        <?= $i; ?>
                    </a>

                <?php endfor; ?>


                <?php if ($halaman < $total_halaman) : ?>

                    <a href="?halaman=<?= $halaman + 1; ?>">
                        ›
                    </a>

                <?php else : ?>

                    <span class="disabled">›</span>

                <?php endif; ?>

            </div>

        </div>

    </div>

</main>

</body>

</html>