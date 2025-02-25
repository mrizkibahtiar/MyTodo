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
    <style>
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