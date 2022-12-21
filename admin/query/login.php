<?php

if(isset($_POST['loginPage'])){
    session_start();
    include_once 'conn.php';
    login_page($conn);
}

function login_page($conn)
{
    $user = $_POST['email'];
    $pass = $_POST['pw'];
    if (login($user, $pass, $conn)) {
        $_SESSION['user'] = $_POST['email'];
        $_SESSION['pass'] = $_POST['pw'];
        header('Location: ' . '../index.php');
        die();
    }else{
        $errors = array();
        array_push($errors, 'Nincs ilyen fiók');
        $_SESSION['errors'] = $errors;
        header('Location: ' . '../login.php');
        die();
    }
}

function login($username, $pw, $conn)
{
    $sql = "SELECT email, main FROM admin_users
    WHERE email = '$username' AND password = '$pw';";
    

    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $_SESSION['main'] = $row['main'];
        return true;
    }
    return false;
}
