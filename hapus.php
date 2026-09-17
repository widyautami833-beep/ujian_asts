<?php

include "koneksi.php";

$id = $_GET['id'] ?? '';


if (
    !ctype_digit($id) ||
    $id == '0'
) {

    die("ID tidak valid.");

}


$stmt = mysqli_prepare(
    $koneksi,
    "DELETE FROM users WHERE id = ?"
);


mysqli_stmt_bind_param(
    $stmt,
    "i",
    $id
);


if (mysqli_stmt_execute($stmt)) {

    header("Location: index.php");

    exit;

} else {

    echo "Gagal menghapus data.";

}

?>