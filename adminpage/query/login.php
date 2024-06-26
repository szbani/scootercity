<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['loginPage'])) {
        session_start();
        define('ACCESS_ALLOWED', true);
        include_once 'conn_login.php';
        login_page($conn);
    }
}
if (defined('ACCESS_ALLOWED') || $_SERVER['REQUEST_METHOD'] == 'POST') {
    if (!isset($_SESSION['user']) && !isset($_SESSION['pass'])) {
        header('Location: ' . "http://" . $_SERVER['HTTP_HOST'] . '/adminpage/login.php');
        die();
    }
    if (!login($_SESSION['user'], $_SESSION['pass'], $conn)) {
        header('Location: ' . "http://" . $_SERVER['HTTP_HOST'] . '/adminpage/login.php');
        die();
    }
} else {
    exit();
}

function login_page($conn)
{
    $user = mysqli_real_escape_string($conn,$_POST['email']);
    $pass = mysqli_real_escape_string($conn,$_POST['pw']);
    if (login($user, $pass, $conn)) {
        $_SESSION['user'] = $user;
        $_SESSION['pass'] = $pass;
        logAction($conn, "Bejelentkezett", $user);
        $_SESSION['success'] = 'Sikeres Bejelentkezés';
        header('Location: ' . '../index.php');
        die();
    } else {
        $_SESSION['error'] = 'Nincs ilyen fiók';
        header('Location: ' . '../login.php');
        die();
    }
}

function login($username, $pw, $conn)
{
    $sql = "SELECT email,password, main FROM admin_users
    WHERE email = '$username';";

    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        if (password_verify($pw, $row['password'])) {
            $_SESSION['main'] = $row['main'];
            return true;
        }
    }
    return false;
}

function logAction($db, $action, $user)
{
    $ip = $_SERVER['REMOTE_ADDR'];
    // $details = json_decode(file_get_contents("http://ipinfo.io/{$ip}/json"));
    // $loc = $ip . "\n" .
    //     $details->country . ": " . $details->city;
    $t = time();
    $time = date("y-m-d H:i:sa", $t);
    $sql = "INSERT INTO logs (user, action, time, ip) 
    VALUES ('$user','$action','$time','$ip')";
    mysqli_query($db, $sql);
}
