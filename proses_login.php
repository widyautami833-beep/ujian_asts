<?php
session_start();
include "koneksi.php";

$username = $_POST['username'] ?? '';
$password = $_POST['password'] ?? '';

$query = "SELECT * FROM admin WHERE username = ?";

$stmt = mysqli_prepare($koneksi, $query);
mysqli_stmt_bind_param($stmt, "s", $username);
mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);
$admin = mysqli_fetch_assoc($result);

if ($admin && password_verify($password, $admin['password'])) {
    $_SESSION['admin'] = $admin['username'];

    header("Location: dashboard.php");
    exit;
} else {
    echo "<script>
        alert('Username atau password salah!');
        window.location='login.php';
    </script>";
}
?>