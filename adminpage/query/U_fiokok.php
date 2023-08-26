<?php
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    exit;
}

define('ACCESS_ALLOWED', true);
require_once "conn.php";
require_once 'login.php';

$errors = array();

if (!isset($_POST['delete'])) {

    if (empty($_POST['email'])) {
        array_push($errors, "Nem adtál meg email címet!");
    }
    if (empty($_POST['pass1'])) {
        array_push($errors, "Nem adtál jelszót!");
    }
    if ($_POST['pass1'] != $_POST['pass2']) {
        array_push($errors, "A két jelszó nem eggyezik meg!");
    }
    if (count($errors) != 0) {
        $_SESSION['errors'] = json_encode($errors);
        back();
    }

    $inputemail = mysqli_real_escape_string($conn, $_POST['email']);
    $inputpass = password_hash(mysqli_real_escape_string($conn, $_POST['pass1']),PASSWORD_DEFAULT);
}

if (isset($_POST['upload'])) {
    if($_SESSION['main'] == 0){
        $check = "SELECT * FROM admin_users WHERE email = '$inputemail'";
        $result = mysqli_query($conn, $check);
    
        if (mysqli_num_rows($result) < 1) {
            $sql = "INSERT INTO admin_users (email, password, main) 
                    VALUES('$inputemail','$inputpass',1)";
            mysqli_query($conn, $sql);
    
            $_SESSION['success'] = 'Sikeres Felvétel';
            logAction($conn,"létrehozott ". $inputemail ." email-el egy fiókot",$_SESSION['user']);
            back();
        } else {
            array_push($errors, "A fiók már létezik!");
        }
    }else{
        array_push($errors,'Nincs ehez a művelethez jogod!');
    }
    $_SESSION['errors'] = json_encode($errors);
    back();
} else if (isset($_POST['edit'])) {
    $id = mysqli_real_escape_string($conn, $_POST['id']);
    $name = $_SESSION['user'];

    $check = "SELECT * FROM admin_users WHERE email = '$name'";
    $result = mysqli_query($conn, $check);

    $row = mysqli_fetch_assoc($result);
    if ($id == $row['id'] || $row['main'] == 0) {
        if ($row['main'] == 0) {
            $sql = "UPDATE admin_users SET password = '$inputpass'
            WHERE id = '$id'";
            mysqli_query($conn, $sql);

            $_SESSION['success'] = 'Sikeres módosítás';
            if ($name == $inputemail) $_SESSION['pass'] = $inputpass;
        } else if ($row['email'] == $inputemail) {
            $sql = "UPDATE admin_users SET password = '$inputpass'
            where id = $id";
            mysqli_query($conn, $sql);

            $_SESSION['success'] = 'Sikeres módosítás';
            $_SESSION['pass'] = $inputpass;
        } else {
            array_push($errors, "Nincs jogod a fiók módosításához!");
            back();
        }
        
        logAction($conn, "Módosította " . $inputemail . " felhasználót. ", $name);
        $_SESSION['success'] = "Sikeres Módosítás";
        back();
    }
    array_push($errors,"Valamilyen hiba lépett fel");
    $_SESSION['errors'] = json_encode($errors);
    back();
} else if (isset($_POST['delete'])) {
    $id = mysqli_real_escape_string($conn, $_POST["id"]);
    $sql = "SELECT email FROM admin_users where id = '$id'";
    $result = mysqli_query($conn, $sql);
    $email = mysqli_fetch_assoc($result);

    if($email['email'] == $_SESSION['user']){
        array_push($errors,"Nem tudod kitörölni a saját fiókodat");
        echo json_encode(array('success' => true, 'messages' => $errors));
        die();
    }
    if($_SESSION['main'] == 0){
        $sql = "DELETE FROM admin_users where id = '$id'";
        mysqli_query($conn, $sql);

        logAction($conn, "Törölte a " . $email['email'] . " felhasználót.", $_SESSION['user']);
        echo json_encode(array('success' => true, 'messages' => array('Törölted ('.$id.')'. $email['email'] . ' felhasználót.')));
    }else{
        array_push($errors, "Nincs jogod ehez a művelethez");
        echo json_encode(array('success' => true, 'messages' => $errors));
    }
}else{
    back();
}

function back()
{
    header('location: ../fiokok.php');
    die();
}
