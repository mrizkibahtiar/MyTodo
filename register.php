<?php
require "functions.php";

if (isset($_POST["submit"])) {
    if (registrasi($_POST) != 0) {
        echo "<script>
        alert('data berhasil ditambahkan!')
        </script>";
    } else {
        // $error = "terjadi kesalahan dalam menambahkan data";
        mysqli_error($conn);
    }
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MyTodo - Register</title>
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
            font-size: 20px;
            margin-bottom: 10px;
        }
    </style>
</head>

<body>
    <h1>MyTodo</h1>
    <?php if (isset($error)): ?>
        <div class="warning">
            <?= $error; ?>
        </div>
    <?php endif ?>
    <form action="" method="post">
        <div>
            <label for="email">Username</label>
            <input type="text" name="username" id="username">
        </div>
        <div>
            <label for="password">Password</label>
            <input type="password" name="password" id="password">
        </div>
        <div>
            <label for="password2">Konfirmasi Password</label>
            <input type="password" name="password2" id="password2">
        </div>
        <button type="submit" name="submit">Daftar</button>
        <p>Sudah punya akun? <a href="index.php">klik disini!</a></p>
    </form>
</body>

</html>