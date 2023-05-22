<?php
if (!defined('ACCESS_ALLOWED'))exit();
session_start();
if (isset($_SESSION['main'])){
    $host = "localhost";
    $user = "root";
    $pass = "";
    $database = "scootercity";
    $conn = mysqli_connect($host, $user, $pass, $database);

    if (mysqli_connect_errno()) {
        echo "Nem sikerült csatlakozni a szerverhez";
        exit();
    }
}
if (!isset($_SESSION['user']) && !isset($_SESSION['pass'])) {
    header('Location: ' . "http://" . $_SERVER['HTTP_HOST'] . '/adminpage/login.php');
    die();
}


