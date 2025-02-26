<?php
session_start();
require "functions.php";

if (isset($_POST["login"])) {
    global $conn;
    $username = $_POST["username"];
    $password = $_POST["password"];

    $result = mysqli_query($conn, "SELECT * FROM tb_user WHERE username = '$username'");

    if (mysqli_num_rows($result) === 1) {
        // cek password
        $row = mysqli_fetch_assoc($result);
        if (password_verify($password, $row["password"])) {
            $_SESSION["login"] = true;
            $_SESSION["id"] = $row["id"];
            header("Location: dashboard.php");
            exit;
        }
    }

    $error = true;
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MyTodo - To Do List Apps</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,200..800;1,200..800&display=swap"
        rel="stylesheet">

    <style>
        body {
            font-family: "Plus Jakarta Sans", serif;
        }

        .warning {
            color: red;
            font-weight: bold;
        }
    </style>
</head>

<body>
    <h1>MyTodo</h1>

    <!-- error -->
    <?php if (isset($error)): ?>
        <p class="warning">Username / Password salah!</p>
    <?php endif; ?>

    <form action="" method="post">
        <div>
            <label for="email">Username</label>
            <input type="text" name="username" id="username">
        </div>
        <div>
            <label for="password">Password</label>
            <input type="password" name="password" id="password">
        </div>
        <button type="submit" name="login" id="login">Masuk</button>
    </form>
    <p>Belum punya akun? <a href="register.php">Klik Disini.</a></p>

</body>

</html>