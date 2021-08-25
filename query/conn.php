<?php
$host = "localhost";
$username = "root";
$password = "";
$dbname = "scootercity";
$port = "3306";
$conn = new mysqli($host,$username,$password,$dbname,$port);


  if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
  }




?>