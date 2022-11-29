<?php
$host = "localhost";
$user = "root";
$pass = "";
$database = "scootercity";
$conn = mysqli_connect($host,$user,$pass,$database);
if(mysqli_connect_errno()){
    echo "Nem sikerült csatlakozni a szerverhez";
    exit();
}
?>