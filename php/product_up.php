<?php
session_start();

$errors = array();

if(isset($_POST["product_upload"]) || isset($_POST["product_edit_confirm"]))
{

    $filetoupload = "";

    if (empty($_POST['name'])) { array_push($errors, "Hiányzik a termék neve!"); }
    if (empty($_POST['price'])) { array_push($errors, "Hiányzik a termék ára!"); }
    if (empty($_POST['desc'])) { array_push($errors, "Hiányzik a termék leírás!"); }
    
    if(ctype_digit($_POST['price']) == false){ array_push($errors, $_POST['price']);
        array_push($errors, "Nem megfelelő az ár formátuma"); }

    if($_FILES['fileToUpload']['name'] != ""){
        if(count($errors) == 0){
            include "file_upload.php";
            $filetoupload = $_FILES['fileToUpload']['name'];
        }
    }
    else if($_POST['fileToSelect'] != ""){
        if(count($errors) == 0){
            $filetoupload = $_POST['fileToSelect'];
        } 
    }
    else{
        array_push($errors, 'nem választottál ki képet.');
    }

    if(count($errors) == 0){
        include("mysql_conn.php");

        $inputname = mysqli_real_escape_string($conn,$_POST['name']);
        $inputprice = mysqli_real_escape_string($conn,$_POST['price']);
        $inputdesc = mysqli_real_escape_string($conn,$_POST['desc']);
        if(isset($_POST["product_upload"])){
            $sql = "INSERT INTO products (name, image, price, description) 
            VALUES('$inputname','$filetoupload','$inputprice','$inputdesc')";
            mysqli_query($conn, $sql);
        }
        else if(isset($_POST["product_edit_confirm"])){
            $id = $_POST['id'];
            $sql = "UPDATE products SET name = '$inputname', image = '$filetoupload',
            price = '$inputprice', description = '$inputdesc' WHERE id = $id";
            mysqli_query($conn, $sql);
        }
        $conn->close();
    }
    else{
        array_push($errors, "Nem sikerült a termék felvétele!");
    }
    
    $_SESSION['errors'] = $errors;
}

header('location: ../admin.php#products');
?>
