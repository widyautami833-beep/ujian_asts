<?php

include "koneksi.php";

$id = $_GET['id'] ?? '';

$nama = '';
$nisn = '';
$ttl = '';
$gender = '';
$email = '';
$address = '';

$judul = "Tambah Data User";

if (
    $id !== '' &&
    ctype_digit($id) &&
    (int)$id > 0
) {

    $id_number = (int)$id;

    $stmt = mysqli_prepare(
        $koneksi,
        "SELECT * FROM users WHERE id = ?"
    );

    mysqli_stmt_bind_param(
        $stmt,
        "i",
        $id_number
    );

    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);

    $row = mysqli_fetch_assoc($result);

    if ($row) {

        $nama = $row['name'];
        $nisn = $row['nisn'];
        $ttl = $row['ttl'];
        $gender = $row['gender'];
        $email = $row['email'];
        $address = $row['address'];

        $judul = "Edit Data User";

    }

}

?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta
    name="viewport"
    content="width=device-width, initial-scale=1.0">

<title><?= $judul ?> - Ujian ASTS</title>

<link rel="stylesheet" href="style.css">

</head>
<body>

<!-- ================= SIDEBAR ================= -->

<aside class="sidebar">

    <div class="logo">
        UJIAN ASTS
        <small>Student Management</small>
    </div>


    <div class="menu-title">
        MENU UTAMA
    </div>


    <a href="dashboard.php" class="menu">
            ⌂ Dashboard
    </a>

    <a href="index.php" class="menu">
            ♙ Data Users
    </a>

    <a href="form.php" class="menu active">
            + Tambah Data
    </a>


    <div class="menu-title">
        DATA
    </div>


    <a href="data_json.php" class="menu">
        { } JSON API
    </a>

</aside>


<!-- ================= MAIN ================= -->

<main class="main">

    <div class="container">


        <div class="header">

            <h2>
                <?= $judul ?>
            </h2>

            <p>
                Silakan isi data dengan benar
            </p>

        </div>


        <form
            action="simpan.php"
            method="POST">


            <input
                type="hidden"
                name="id"
                value="<?= htmlspecialchars($id) ?>">


            <!-- NAMA -->

            <label>
                Nama Lengkap
            </label>

            <input
                type="text"
                name="name"

                placeholder="Masukkan nama lengkap"

                value="<?= htmlspecialchars($nama) ?>"

                required>


            <!-- NISN -->

            <label>
                NISN
            </label>

            <input
                type="text"
                name="nisn"

                placeholder="Masukkan 10 angka NISN"

                value="<?= htmlspecialchars($nisn ?? '') ?>"

                minlength="10"

                maxlength="10"

                pattern="[0-9]{10}"

                title="NISN harus tepat 10 angka"

                inputmode="numeric"

                required>


            <div class="info">
                NISN harus tepat 10 angka.
            </div>


            <!-- TTL -->

            <label>
                Tempat, Tanggal Lahir
            </label>

            <input
                type="text"
                name="ttl"

                placeholder="Contoh: Ponorogo, 12 Agustus 2010"

                value="<?= htmlspecialchars($ttl ?? '') ?>">


            <!-- GENDER -->

            <label>
                Gender
            </label>

            <select
                name="gender"
                required>

                <option value="">
                    -- Pilih Gender --
                </option>

                <option
                    value="MALE"
                    <?= $gender == 'MALE'
                        ? 'selected'
                        : '' ?>>

                    MALE

                </option>

                <option
                    value="FEMALE"
                    <?= $gender == 'FEMALE'
                        ? 'selected'
                        : '' ?>>

                    FEMALE

                </option>

            </select>


            <!-- EMAIL -->

            <label>
                Email
            </label>

            <input
                type="email"
                name="email"

                placeholder="Masukkan email aktif"

                value="<?= htmlspecialchars($email) ?>"

                required>


            <!-- ALAMAT -->

            <label>
                Alamat
            </label>

            <textarea
                name="address"
                placeholder="Masukkan alamat lengkap"><?= htmlspecialchars($address ?? '') ?></textarea>


            <!-- BUTTON -->

            <button type="submit">

                💾 Simpan Data

            </button>


        </form>


        <a
            href="index.php"
            class="kembali">

            ← Kembali ke Tabel

        </a>


    </div>

</main>

</body>

</html>