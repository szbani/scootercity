<?php

function login_page($conn)
{
    $user = $_POST['username'];
    $pass = $_POST['pw'];
    if (login($user, $pass, $conn)) {
        $_SESSION['user'] = $_POST['username'];
        $_SESSION['pass'] = $_POST['pw'];
        header('Location: ' . 'index.php');
    }else{
        $errors = array();
        array_push($errors, 'Nincs ilyen fiók');
        $_SESSION['errors'] = $errors;
        header('Location: ' . 'login.php');
    }
}

function login($username, $pw, $conn)
{
    $sql = "SELECT username FROM admin_users
    WHERE username = '$username' AND password = '$pw';";

    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {
        return true;
    }
    return false;
}
