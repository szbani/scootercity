<?php
$host = "localhost";
$user = "root";
$pass = "";
$database = "scootercity";
$conn = mysqli_connect($host, $user, $pass, $database);
if (mysqli_connect_errno()) {
    echo "Nem sikerült csatlakozni a szerverhez";
    exit();
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
