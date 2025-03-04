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

        body {
            padding-inline: 200px;
        }

        .container1 {
            display: flex;
            align-items: center;
            justify-content: space-between;
            height: 100px;
        }

        .container1 .highlight {
            font-size: 2.9rem;
            font-weight: bold;
        }

        .container1 .user-task {
            padding: 10px;
            width: 200px;
            border: 1px solid rgb(209, 209, 209);
            display: flex;
            flex-direction: column;
            gap: 3px;
            border-radius: 10px;
            box-shadow: 1px 1px 5px rgba(0, 0, 0, 0.1);
        }

        .container1 .user-task .title {
            display: flex;
            font-weight: 700;
            align-items: center;
            gap: 7px;
        }

        .container1 .user-task .title svg {
            width: 30px;
        }

        .container1 .user-task .task-count {
            margin-left: 37px;
            box-sizing: border-box;
        }

        .line {
            text-decoration: line-through;
            color: rgb(146, 146, 146);
        }

        .selesai {
            color: lightgreen;
        }

        .tugas {
            color: red;
        }

        .jumlah {
            font-weight: 800;
        }

        .hilang {
            visibility: hidden;
            display: none;
        }
    </style>
</head>

<body>
    <div class="container1">
        <div class="user-task">
            <span class="title">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                    <path fill-rule="evenodd"
                        d="M18.685 19.097A9.723 9.723 0 0 0 21.75 12c0-5.385-4.365-9.75-9.75-9.75S2.25 6.615 2.25 12a9.723 9.723 0 0 0 3.065 7.097A9.716 9.716 0 0 0 12 21.75a9.716 9.716 0 0 0 6.685-2.653Zm-12.54-1.285A7.486 7.486 0 0 1 12 15a7.486 7.486 0 0 1 5.855 2.812A8.224 8.224 0 0 1 12 20.25a8.224 8.224 0 0 1-5.855-2.438ZM15.75 9a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0Z"
                        clip-rule="evenodd" />
                </svg>
                <?= $username; ?>
            </span>
            <span class="task-count">
                <?php if (count($task_belum) > 0): ?>
                    <span class="jumlah"><?= count($task_belum); ?></span>
                    <span class="tugas"> tugas belum selesai</span>
                <?php else: ?>
                    <span class="selesai">tidak ada tugas</span>
                <?php endif; ?>
            </span>
        </div>
        <p class="highlight">MyTodo</p>
        <div>
            <a href="logout.php">logout</a>
        </div>
    </div>
    <d$taslass="container2">
        <div class="add-task">
            <div class="img">
                <img src="img/plus.png" alt="plus" width="30px">
            </div>
            <p>Add New Task</p>
        </div>
        <form action="" method="post" class="form-add hilang">
            <input type="text" name="task" id="task">
            <button type="submit" name="addTask" id="addTask">Simpan</button>
        </form>
        </d$taslass=>
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
        <script src="js/script.js">
        </script>
        <script>
            // handle visibilitas form add
            const addButton = document.querySelector('.add-task');
            const formAdd = document.querySelector('.form-add');
            addButton.addEventListener('click', () => {
                formAdd.classList.toggle('hilang');
            })
        </script>
</body>

</html>