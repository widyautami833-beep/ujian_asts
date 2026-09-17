<?php

include "koneksi.php";

$id = $_POST['id'] ?? '';

$name = $_POST['name'] ?? '';
$nisn = $_POST['nisn'] ?? '';
$ttl = $_POST['ttl'] ?? '';
$gender = $_POST['gender'] ?? '';
$email = $_POST['email'] ?? '';
$address = $_POST['address'] ?? '';


/* CEK NISN */

if (!preg_match('/^[0-9]{10}$/', $nisn)) {

    die("NISN harus tepat 10 angka.");

}


/* TAMBAH DATA */

if ($id == '') {

    $query = mysqli_prepare(
        $koneksi,

        "INSERT INTO users
        (name, nisn, ttl, gender, email, address)
        VALUES (?, ?, ?, ?, ?, ?)"
    );

    mysqli_stmt_bind_param(
        $query,
        "ssssss",

        $name,
        $nisn,
        $ttl,
        $gender,
        $email,
        $address
    );

}


/* EDIT DATA */

else {

    $query = mysqli_prepare(
        $koneksi,

        "UPDATE users SET

        name = ?,
        nisn = ?,
        ttl = ?,
        gender = ?,
        email = ?,
        address = ?

        WHERE id = ?"
    );

    mysqli_stmt_bind_param(
        $query,
        "ssssssi",

        $name,
        $nisn,
        $ttl,
        $gender,
        $email,
        $address,
        $id
    );

}


/* SIMPAN */

if (mysqli_stmt_execute($query)) {

    header("Location: index.php");

    exit;

} else {

    echo "Gagal menyimpan data: "
        . mysqli_error($koneksi);

}

?>