<?php
require "functions.php";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MyTodo - Register</title>
</head>

<body>
    <h1>MyTodo</h1>
    <form action="" method="post">
        <div>
            <label for="email">Username</label>
            <input type="text" name="email" id="">
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
    </form>
</body>

</html>