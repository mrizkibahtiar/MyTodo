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


// handle button edit
if (isset($_POST["edit"])) {
    if (edit($_POST) > 0) {
        header('Location: dashboard.php');
    } else {
        echo "<script>
        alert('data tidak berhasil diubah!');
        </script>";
    }
}



?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MyTodo - Dashboard</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,200..800;1,200..800&display=swap"
        rel="stylesheet">
    <style>
        body,
        * {
            font-family: "Plus Jakarta Sans", serif;
        }

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

        .add-task {
            display: flex;
            gap: 10px;
            align-items: center;
            cursor: pointer;
        }

        .add-task img {
            margin-top: 7px;
        }

        .add-task:hover {
            font-weight: 800;
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

        .outer {
            display: flex;
            width: 100%;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }

        .container-list {
            width: 70%;
            list-style: none;
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .task-list {
            width: 60%;
            cursor: pointer;
            margin-bottom: 11px;
        }

        .line {
            text-decoration: line-through;
            color: rgb(146, 146, 146);
        }

        .selesai {
            color: lightgreen;
            font-weight: 800;
        }

        .tugas {
            color: red;
            font-weight: 800;
        }

        .jumlah {
            font-weight: 800;
        }

        .container-task {
            display: flex;
            gap: 10px;
        }

        .link {
            text-decoration: none;
        }

        .hilang {
            visibility: hidden;
            display: none;
        }
    </style>
</head>

<body>
    <div class="container">
        <div>
            <p class="title"><?= $username; ?></p>
            <p class="task-count">
                <?php if (count($task_belum) > 0): ?>
                    <span class="jumlah"><?= count($task_belum); ?></span>
                    <span class="tugas"> tugas belum selesai</span>
                <?php else: ?>
                    <span class="selesai">tidak ada tugas</span>
                <?php endif; ?>
            </p>
        </div>
        <div>
            <p class="highlight">MyTodo</p>
        </div>
        <div>
            <a href="logout.php">logout</a>
        </div>
    </div>
    <div class="container2">
        <div class="add-task">
            <div class=".img">
                <img src="img/plus.png" alt="plus" width="30px">
            </div>
            <p>Add New Task</p>
        </div>
        <form action="" method="post" class="form-add hilang">
            <input type="text" name="task" id="task">
            <button type="submit" name="addTask" id="addTask">Simpan</button>
        </form>
    </div>
    <div class="outer">
        <h1>Daftar To Do List</h1>
        <ul class="container-list">
            <?php foreach ($tasks as $task): ?>
                <div class="container-task">
                    <div>
                        <a class="link" href="hapus.php?id=<?= $task['id'] ?>" onclick="return confirm('yakin?')">
                            <img src="img/trash.png" alt="trash" width="23px">
                        </a>
                        <p class="link button-edit">
                            <img src="img/pencil.png" alt="pencil" width="23px">
                        </p>
                    </div>
                    <li class="task-list" data-id="<?= $task['id']; ?>">
                        <?= $task['task'] ?>

                        <input type="hidden" name="status-task" class="status-task" value="<?= $task['status']; ?>">
                    </li>
                    <form action="" method="post" class="form-edit hilang">
                        <input type="text" name="task-edit" class="task-edit" value="<?= $task['task'] ?>">
                        <input type="hidden" name="task-id" class="task-id" value="<?= $task['id']; ?>">
                        <button type="submit" name="edit" id="edit">edit</button>
                    </form>
                </div>
            <?php endforeach; ?>
        </ul>
    </div>
    <script src="js/script.js"></script>
</body>

</html>