<?php
require "functions.php";

if (isset($_POST["login"])) {
    login($_POST);
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MyTodo - To Do List Apps</title>
</head>

<body>
    <h1>MyTodo</h1>
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