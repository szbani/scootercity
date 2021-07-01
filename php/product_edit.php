<?php
session_start();

$errors = array();
$data = array();

if(isset($_POST['prod_edit'])){
    
    include('mysql_conn.php');
    $id = $_POST['id'];
    $sql = "SELECT id, name, image, price, description FROM products WHERE id=$id";
    $result = mysqli_query($conn, $sql);
    
    if(mysqli_num_rows($result) > 0){

        while($row = mysqli_fetch_assoc($result)){
            $edit = "prod";
            $id = $row['id'];
            $name = $row['name'];
            $image = $row['image'];
            $price = $row['price'];
            $desc = $row['description'];
            array_push($data,$edit, $id, $name, $image, $price, $desc);
        }
        
    }

    $conn->close();
    $_SESSION['edit'] = $data;
}
else if(isset($_POST['prod_del'])){

    include('mysql_conn.php');
    $id = $_POST['id'];
    $sql = "DELETE FROM products WHERE id=$id";
    mysqli_query($conn, $sql);

    $conn->close();
}

$_SESSION['errors'] = $errors;
header('location: ../admin.php#products');

?>