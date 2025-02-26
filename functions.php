<?php

// buat koneksi
$conn = mysqli_connect("localhost", "root", "", "mytodo");

function registrasi($data)
{
    global $conn;
    $username = strtolower(stripslashes($data["username"]));
    $password = mysqli_escape_string($conn, $data["password"]);
    $password2 = mysqli_escape_string($conn, $data["password2"]);

    // cek username sudah ada atau belum
    $result = mysqli_query($conn, "SELECT * FROM tb_user WHERE username = '$username'");

    // pengecekan username
    if (strlen($username) < 8) {
        echo "<script>
        alert('username kurang panjang!')
        </script>";
        return 0;
    } else if (mysqli_fetch_assoc($result)) {
        echo "<script>
        alert('username sudah digunakan!')
        </script>";
        return 0;
    }


    // pengecekan password
    if (strlen($password) < 8) {
        echo "<script>
        alert('password kurang panjang!')
        </script>";
        return 0;
    }

    if ($password !== $password2) {
        "<script>
        alert('password tidak sama!')
        </script>";
        return 0;
    }

    // enkripsi password
    $password = password_hash($password, PASSWORD_DEFAULT);

    mysqli_query($conn, "INSERT INTO tb_user VALUES ('', '$username', '$password')");

    return mysqli_affected_rows($conn);
}

function tambah($data)
{
    global $conn;
    $task = stripslashes(htmlspecialchars($data["task"]));
    $id = $_SESSION["id"];

    mysqli_query($conn, "INSERT INTO tb_task VALUES ('', '$task', 'belum', $id)");
}

function query($query)
{
    global $conn;
    $result = mysqli_query($conn, $query);

    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }

    return $rows;
}