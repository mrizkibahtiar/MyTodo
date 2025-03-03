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
        * {
            font-family: "Plus Jakarta Sans", serif;
        }

        body {
            width: 100%;
            overflow: hidden;
        }

        .warning {
            color: red;
            font-weight: bold;
        }

        .highlight {
            font-size: 50px;
        }

        .container {
            margin-inline: auto;
            text-align: center;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .container-form {
            background-color: white;
            box-shadow: 1px 5px 10px rgba(0, 0, 0, 0.1);
            padding-inline: 25px;
            padding-block: 30px;
            border-radius: 10px;
            border: 1px solid rgba(203, 203, 203, 0.87);
        }

        .container-form .username,
        .password {
            display: flex;
            width: 400px;
            flex-direction: column;
            align-items: center;
        }

        .container-form .username label,
        .password label {
            align-self: baseline;
            margin-bottom: 10px;
            font-weight: bold;
        }

        .container-form .username input,
        .password input {
            box-sizing: border-box;
            width: 100%;
            margin-bottom: 10px;
            height: 40px;
            border-radius: 10px;
            padding-inline: 10px;
            border: 1px solid gainsboro;
            font-size: 15px;
        }

        .container-form .username input:focus,
        .container-form .password input:focus {
            border: 1px solid black;
            outline: none;
        }

        .container-form #login {
            margin-top: 10px;
            width: 100%;
            height: 40px;
            font-size: 15px;
            font-weight: bold;
            color: white;
            background-color: black;
            border-radius: 10px;
            cursor: pointer;
        }

        .container-form #login:hover {
            transition-duration: 440ms;
            background-color: white;
            color: black;
            border: 2px solid black;
        }

        .container-register {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            text-align: center;
        }

        .container-register a {
            text-decoration: none;
            color: rgb(31, 0, 184);
            font-weight: bolder;
        }

        .container-register a:hover {
            color: gray;
            transition-duration: 350ms;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1 class="highlight">MyTodo - Login</h1>

        <!-- error -->
        <?php if (isset($error)): ?>
            <p class="warning">Username / Password salah!</p>
        <?php endif; ?>

        <div class="container-form">
            <form action="" method="post">
                <div class="username">
                    <label for="email">Username</label>
                    <input type="text" name="username" id="username" placeholder="username">
                </div>
                <div class="password">
                    <label for="password">Password</label>
                    <input type="password" name="password" id="password" placeholder="password">
                </div>
                <button type="submit" name="login" id="login">Masuk</button>
            </form>
        </div>
    </div>
    <div class="container-register">
        <p>Belum punya akun?</p>
        <a href="register.php">Klik Disini</a>
    </div>

</body>

</html>