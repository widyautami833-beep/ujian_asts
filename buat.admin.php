
<?php
include "koneksi.php";

$username = "admin";
$password = password_hash("admin123", PASSWORD_DEFAULT);

$query = "INSERT INTO admin (username, password)
          VALUES (?, ?)";

$stmt = mysqli_prepare($koneksi, $query);
mysqli_stmt_bind_param($stmt, "ss", $username, $password);

if (mysqli_stmt_execute($stmt)) {
    echo "Admin berhasil dibuat!";
    echo "<br>Username: admin";
    echo "<br>Password: admin123";
} else {
    echo "Gagal membuat admin: " . mysqli_error($koneksi);
}
?>