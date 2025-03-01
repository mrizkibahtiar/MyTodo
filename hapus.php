<?php
session_start();
require "functions.php";

if (!$_SESSION["login"]) {
    header('Location: index.php');
}

$id = $_GET['id'];

if (hapus($id) > 0) {
    echo "<script>
    document.location.href = 'dashboard.php';
    </script>";

} else {
    echo "<script>alert('Task berhasil dihapus');
    document.location.href = 'dashboard.php';
    </script>";
}