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

$id = $_SESSION["id"];

// kueri menampilkan data task
$tasks = query("SELECT * FROM tb_task WHERE user_id = $id");

// memperoleh task mana saja yang belum
$task_belum = [];
for ($i = 0; $i < count($tasks); $i++) {
    if ($tasks[$i]["status"] == 'belum') {
        $task_belum[] = $tasks[$i]["task"];
    }
}

// kueri data pengguna
$username = mysqli_fetch_row(mysqli_query($conn, "SELECT username FROM tb_user WHERE id = $id"))[0];


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

        .title {
            font-size: 1.3rem;
            font-weight: 500;
        }
    </style>
</head>

<body>
    <div class="container">
        <div>
            <p class="title"><?= $username; ?></p>
            <p><?= count($task_belum); ?> tugas belum selesai</p>
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
                <?php foreach ($tasks as $task): ?>
                    <li><?= $task["task"] ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
</body>

</html>