
<?php
session_start();

if (isset($_SESSION['admin'])) {
    header("Location: dashboard.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - UJIAN ASTS</title>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        body {
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            background: linear-gradient(135deg, #eaf4ff, #f5f8fc);
        }

        .login-box {
            width: 380px;
            background: white;
            padding: 38px;
            border-radius: 20px;
            box-shadow: 0 10px 35px rgba(54, 96, 140, 0.12);
            border: 1px solid #e1ebf6;
        }

        .logo {
            text-align: center;
            margin-bottom: 30px;
        }

        .logo h1 {
            color: #174778;
            font-size: 25px;
            margin-bottom: 10px;
        }

        .logo p {
            color: #8ba0b9;
            font-size: 13px;
        }

        label {
            display: block;
            color: #426587;
            font-size: 13px;
            margin-bottom: 8px;
        }

        input {
            width: 100%;
            padding: 13px;
            margin-bottom: 20px;
            border: 1px solid #dce7f3;
            border-radius: 10px;
            outline: none;
            font-size: 14px;
        }

        input:focus {
            border-color: #6ba4df;
            box-shadow: 0 0 0 3px #eaf4ff;
        }

        button {
            width: 100%;
            padding: 13px;
            border: none;
            border-radius: 10px;
            background: #4f91d8;
            color: white;
            font-size: 14px;
            font-weight: bold;
            cursor: pointer;
        }

        button:hover {
            background: #367dc5;
        }

        .footer {
            text-align: center;
            color: #a0b0c2;
            font-size: 11px;
            margin-top: 25px;
        }
    </style>
</head>

<body>

    <div class="login-box">

        <div class="logo">
            <h1>UJIAN ASTS</h1>
            <p>Student Management System</p>
        </div>

        <form action="proses_login.php" method="POST">

            <label>Username</label>
            <input
                type="text"
                name="username"
                placeholder="Masukkan username"
                required
            >

            <label>Password</label>
            <input
                type="password"
                name="password"
                placeholder="Masukkan password"
                required
            >

            <button type="submit">LOGIN</button>

        </form>

        <div class="footer">
            Sistem Pengelolaan Data Siswa
        </div>

    </div>

</body>
</html>