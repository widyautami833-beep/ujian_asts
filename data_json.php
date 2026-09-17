
<?php
include "koneksi.php";

header("Content-Type: application/json; charset=UTF-8");

$query = mysqli_query(
    $koneksi,
    "SELECT
        id,
        name,
        nisn,
        ttl,
        gender,
        email,
        address
     FROM users
     ORDER BY id ASC"
);

$data = [];

while ($row = mysqli_fetch_assoc($query)) {
    $data[] = [
        "id" => (int) $row["id"],
        "name" => $row["name"],
        "nisn" => $row["nisn"],
        "ttl" => $row["ttl"],
        "gender" => $row["gender"],
        "email" => $row["email"],
        "address" => $row["address"]
    ];
}

echo json_encode(
    $data,
    JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE
);
?>