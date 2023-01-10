<?php
session_start();
require_once "conn.php";
require_once 'login.php';

if(isset($_POST['upload'])){

}else if(isset($_POST['edit'])){

}else if(isset($_POST['delete'])){
    $id = $_POST['id'];
    $sql = "SELECT nev FROM termekek where id = '$id'";
    $result = mysqli_query($conn, $sql);
    $nev = mysqli_fetch_assoc($result);
    $sql = "DELETE FROM termekek where id = '$id'";
    mysqli_query($conn,$sql);
    logAction($conn,"Törölte ezt a terméket: ".$nev['nev'].".",$_SESSION['user']);
    $_SESSION['success'] = 'Sikeres törlés';
    back();
}
back();
function back()
{
    header('location: ../termekek.php');
    die();
}
?>