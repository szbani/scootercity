<?php
session_start();
require_once("conn.php");
require_once 'login.php';

if (isset($_POST['submit'])) {


    $errors = array();
    $sql = 'INSERT INTO admin_users VALUES ($_POST["name"],$_POST["pass"])';

    if (empty($_POST['email'])) {
        array_push($errors, "Nem adtál meg email címet!");
    }
    if (empty($_POST['pass1'])) {
        array_push($errors, "Nem adtál jelszót!");
    }
    if ($_POST['pass1'] != $_POST['pass2']) {
        array_push($errors, "A két jelszó nem eggyezik meg!");
    }

    if (count($errors) == 0) {
        $inputemail = mysqli_real_escape_string($conn, $_POST['email']);
        $inputpass = mysqli_real_escape_string($conn, $_POST['pass1']);
        if (isset($_POST['id'])) $id = true;
        else $id = false;
        //upload
        if (!$id) {
            $check = "SELECT * FROM admin_users WHERE email = '$inputemail'";
            $result = mysqli_query($conn, $check);
            if (mysqli_num_rows($result) < 1 && !$md) {
                $sql = "INSERT INTO admin_users (email, password, main) 
                VALUES('$inputemail','$inputpass',1)";
                mysqli_query($conn, $sql);
                
                $_SESSION['success'] = 'Sikeres Felvétel';
                logAction($conn,"Létrehozta ".$inputemsail." felhasználót",$_SESSION['user']);
            } else {
                array_push($errors, "A fiók már létezik!", 'Sikertelen feltöltés!');
            }
        }
        //edit
        else if ($id) {
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
                    if($name == $inputemail)$_SESSION['pass'] = $inputpass;
                } else if ($row['email'] == $inputemail) {
                    $sql = "UPDATE admin_users SET password = '$inputpass' where id = $id";
                    mysqli_query($conn, $sql);
                    $_SESSION['success'] = 'Sikeres módosítás';
                    $_SESSION['pass'] = $inputpass;
                } else {
                    array_push($errors, "Nincs jogod a fiók módosításához!", 'Sikertelen módisítás!');
                    back();
                }
                logAction($conn,"Módosította ".$inputemail." felhasználót. ",$name);
            }
        }
        back();
    }
    if (isset($_POST['id']))
        array_push($errors, 'Sikertelen módosítás!');
    else array_push($errors, 'Sikertelen feltöltés!');
    $_SESSION['errors'] = $errors;
    back();
} else if (isset($_POST['delete'])) {
    $id = $_POST["id"];
    $sql = "SELECT email FROM admin_users where id = '$id'";
    $result = mysqli_query($conn, $sql);
    $email = mysqli_fetch_assoc($result);
    $sql = "DELETE FROM admin_users where id = '$id'";
    mysqli_query($conn,$sql);
    logAction($conn,"Törölte a ".$email['email']." felhasználót.",$_SESSION['user']);
    $_SESSION['success'] = 'Sikeres törlés';
    back();
}
back();
function back()
{
    header('location: ../fiokok.php');
    die();
}
