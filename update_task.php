<?php
require "functions.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = intval($_POST["id"]); //intval mengubah str to int
    $status = $_POST["status"];

    $query = "UPDATE tb_task SET status = '$status' WHERE id = $id";
    mysqli_query($conn, $query);
}