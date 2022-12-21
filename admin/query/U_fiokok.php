<?php
session_start();
require_once("conn.php");

if(isset($_POST['submit'])){
    

    $errors = array();
    $sql = 'INSERT INTO admin_users VALUES ($_POST["name"],$_POST["pass"])';

    if (empty($_POST['email'])) { array_push($errors, "Nem adtál meg email címet!"); }
    if (empty($_POST['pass1'])) { array_push($errors, "Nem adtál jelszót!"); }
    if($_POST['pass1'] != $_POST['pass2']){array_push($errors, "A két jelszó nem eggyezik meg!");}

    if(count($errors) == 0){
        $inputemail = mysqli_real_escape_string($conn,$_POST['email']);
        $inputpass = mysqli_real_escape_string($conn,$_POST['pass1']);
        

        $md_name = mysqli_real_escape_string($conn,$_POST['md_value']);
        if(isset($_POST['md_check']))$md = true;
        else $md = false;

        //upload
        if(!$md){
            $check = "SELECT * FROM admin_users WHERE email = '$inputemail'";
            $result = mysqli_query($conn, $check);
            if(mysqli_num_rows($result) < 1 && !$md){
                $sql = "INSERT INTO admin_users (email, password, main) 
                VALUES('$inputemail','$inputpass',1)";
                mysqli_query($conn, $sql);
                $_SESSION['succes'] = 'Sikeres Felvétel';
                back();
            }else{array_push($errors, "A fiók már létezik!");}
        }
        //edit
        else if($md){
            $name = $_SESSION['user'];
            $check = "SELECT * FROM admin_users WHERE email = '$name'";
            $result = mysqli_query($conn, $check);
            $row = mysqli_fetch_assoc($result);
            if($_SESSION['user'] == $inputemail || $row['main'] == 0){
                $sql = "UPDATE admin_users SET password = '$inputpass'
                WHERE id = '$md_name'";
                mysqli_query($conn, $sql);
                $_SESSION['succes'] = 'Sikeres módosítás';
                if($_SESSION['user'] == $inputemail){
                    $_SESSION['pass'] = $inputpass;
                }
                back();
            }else{array_push($errors, "Nincs jogod a fiók módosításához!");}
         }
    }
        array_push($errors, "Nem sikerült a felvétel!");
        foreach($errors as $error){
            echo $error ;
            $_SESSION['errors'] = $errors;
        }
    
}
else if(isset($_POST['delete'])){
    $id = $_POST["id"];
    $sql = "DELETE FROM admin_users where id = '$id'";
    mysqli_query($conn, $sql);
    $_SESSION['succes'] = 'Sikeres törlés';
}else{
    back();
}


function back()
{
    header('location: ../fiokok.php');
    die();
}
?>