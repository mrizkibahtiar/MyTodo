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

        /* container 1 */

        .container1 {
            display: flex;
            align-items: center;
            justify-content: space-between;
            height: 100px;
            margin-bottom: 30px;
        }

        .container1 .highlight {
            font-size: 2.9rem;
            font-weight: bold;
        }

        .container1 .user-task {
            margin-top: 35px;
            padding: 10px;
            width: 200px;
            display: flex;
            flex-direction: column;
            gap: 3px;
            border-radius: 10px;
            /* box-shadow: 1px 1px 5px rgba(0, 0, 0, 0.1); */
        }

        .container1 .user-task .title {
            display: flex;
            font-weight: 700;
            align-items: center;
            gap: 7px;
        }

        .container1 a {
            text-decoration: none;
            color: rgb(31, 0, 184);
            font-weight: bolder;
        }

        .container1 a:hover {
            color: rgb(164, 164, 164);
            transition-duration: 150ms;
        }

        /* container 2 */

        .container2 {
            width: 500px;
        }

        .container2 .add-task {
            box-sizing: border-box;
            display: flex;
            align-items: center;
            gap: 12px;
            cursor: pointer;
            border: 1px solid rgb(203, 203, 203);
            width: fit-content;
            padding-inline: 10px;
            border-radius: 10px;
            box-shadow: 2px 2px 5px rgba(0, 0, 0, 0.2);
            transition: all 200ms;
        }

        .container2 .add-task:hover {
            font-weight: bold;
            border: 2px solid black;
            box-shadow: 5px 5px 1px rgba(0, 0, 0, 1);
            transform: translate(-6px, -6px);
        }

        .container2 .add-task img {
            margin-top: 3px;
        }

        .container2 .form-add {
            margin-top: 20px;
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .container2 .form-add input {
            box-sizing: border-box;
            width: 100%;
            height: 40px;
            border-radius: 10px;
            padding-inline: 10px;
            border: 1px solid gainsboro;
            font-size: 15px;
        }

        .container2 .form-add input:focus {
            border: 1px solid black;
            outline: none;
        }

        .container2 .form-add #addTask {
            width: fit-content;
            height: 40px;
            font-size: 15px;
            font-weight: bold;
            color: white;
            background-color: black;
            border-radius: 10px;
            cursor: pointer;

        }

        .container2 .form-add #addTask:hover {
            transition: all 300ms;
            background-color: white;
            color: black;
            border: 2px solid black;
        }

        /* container 3 */
        .container3 .container-task {
            display: flex;
            gap: 30px;
            align-items: center;
        }

        .container3 .container-task .action {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .container3 .container-task .action img {
            cursor: pointer;
        }


        .container3 .container-task .task-list {
            cursor: pointer;
            list-style-type: none;
        }


        .container3 .form-edit {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .container3 .form-edit input {
            box-sizing: border-box;
            width: 100%;
            height: 40px;
            border-radius: 10px;
            padding-inline: 10px;
            border: 1px solid gainsboro;
            font-size: 15px;
        }

        .container3 .form-edit input:focus {
            border: 1px solid black;
            outline: none;
        }

        .container3 .form-edit #edit {
            width: fit-content;
            height: 40px;
            font-size: 15px;
            font-weight: bold;
            color: white;
            background-color: black;
            border-radius: 10px;
            cursor: pointer;

        }

        .container3 .form-edit #edit:hover {
            transition: all 300ms;
            background-color: white;
            color: black;
            border: 2px solid black;
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
            display: none !important;
        }
    </style>
</head>

<body>
    <div class="container1">
        <div class="user-task">
            <span class="title">
                <?= $username; ?>
            </span>
            <span class="task-count">
                <?php if (count($task_belum) > 0): ?>
                    <span class="jumlah">
                        <?= count($task_belum); ?></span>
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
    <div class="container2">
        <div class="add-task">
            <img src="img/plus.png" alt="plus" width="30px">
            <p>Add New Task</p>
        </div>
        <form action="" method="post" class="form-add hilang">
            <input type="text" name="task" id="task" required autocomplete="off">
            <button type="submit" name="addTask" id="addTask">Simpan</button>
        </form>
    </div>
    <div class="container3">
        <h1>Daftar To Do List</h1>
        <ul>
            <?php foreach ($tasks as $task): ?>
                <div class="container-task">
                    <div class="action">
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