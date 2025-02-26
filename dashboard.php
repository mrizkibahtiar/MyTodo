<?php
session_start();

// session handling
if (!$_SESSION["login"]) {
    header('Location: index.php');
    exit;
}

require "functions.php";

// tambah data
if (isset($_POST["addTask"])) {
    tambah($_POST);
}

// kueri menampilkan data
$result = mysqli_query($conn, "SELECT * FROM tb_task");
$rows = [];
while ($row = mysqli_fetch_assoc($result)) {
    $rows[] = $row;
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MyTodo - Dashboard</title>
    <style>
        .container {
            margin-inline: auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
            width: 80%;
        }

        .highlight {
            font-size: 25px;
        }

        .addTask {
            display: flex;
            gap: 10px;
            align-items: center;
        }

        .container2 {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
        }
    </style>
</head>

<body>
    <div class="container">
        <div>
            <p>Username</p>
            <p>task yang belum</p>
        </div>
        <div>
            <p class="highlight">MyTodo</p>
        </div>
        <div>
            <a href="logout.php">logout</a>
        </div>
    </div>
    <div class="container2">
        <div class="addTask">
            <div class=".img">
                <img src="img/plus.png" alt="plus" width="30px">
            </div>
            <p>Add New Task</p>
        </div>
        <form action="" method="post">
            <input type="text" name="task" id="task">
            <button type="submit" name="addTask" id="addTask">Simpan</button>
        </form>
    </div>
    <div>
        <h1>Daftar To Do List</h1>
        <div>
            <ul>
                <?php foreach ($rows as $task): ?>
                    <li><?= $task["task"] ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
</body>

</html>