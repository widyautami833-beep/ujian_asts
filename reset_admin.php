
<?php
include "koneksi.php";

$username = "admin";
$password = password_hash("admin123", PASSWORD_DEFAULT);

$query = "INSERT INTO admin (username, password)
          VALUES (?, ?)
          ON DUPLICATE KEY UPDATE password = ?";

$stmt = mysqli_prepare($koneksi, $query);

mysqli_stmt_bind_param(
    $stmt,
    "sss",
    $username,
    $password,
    $password
);

if (mysqli_stmt_execute($stmt)) {
    echo "Akun berhasil dibuat atau diperbarui!";
    echo "<br>Username: admin";
    echo "<br>Password: admin123";
} else {
    echo "Gagal: " . mysqli_error($koneksi);
}
?>