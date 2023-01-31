<?php
session_start();
require_once "conn.php";
require_once 'login.php';

$errors = array();

if (!isset($_POST['delete'])) {
    if (empty($_POST['nev'])) {
        array_push($errors, "Hiányzik a kategória neve!");
    }

    if (count($errors) != 0) {
        array_push($errors, "Sikertelen Művelet");
        $_SESSION['errors'] = $errors;
        back();
    }
}

if (isset($_POST['upload'])) {

    $inputNev = mysqli_real_escape_string($conn, $_POST['nev']);

    $sqlUpload = "INSERT INTO kategoriak(nev)
                    VALUES('$inputNev')";
    mysqli_query($conn, $sqlUpload);
    logAction($conn, "Létrehozta ezt a Kategóriát: " . $inputNev . ".", $_SESSION['user']);
    $_SESSION['success'] = 'Sikeres Kategória Felvétel';
    back();
} else if (isset($_POST['edit'])) {
    $inputId = mysqli_real_escape_string($conn, $_POST['id']);
    $inputNev = mysqli_real_escape_string($conn, $_POST['nev']);

    $sqlSelectKategoria = "SELECT * FROM kategoriak WHERE id = '$inputId'";
    $result = mysqli_query($conn, $sqlSelectKategoria);
    $oldKategoria = mysqli_fetch_assoc($result);
    $sqlUpdate = "UPDATE kategoriak SET nev = '$inputNev' WHERE id = '$inputId';";
    mysqli_query($conn,$sqlUpdate);
    logAction($conn, "Szerkesztette ezt a Kategóriát: (" . $inputId . ")" . $oldKategoria['nev'] . " -> " . $inputNev . ".", $_SESSION['user']);
    $_SESSION['success'] = 'Sikeres Szerkesztés';
    back();
} else if (isset($_POST['delete'])) {
    $id  = $_POST['id'];
    $sqlDelSelect = "SELECT k.*, (SELECT COUNT(t.nev) FROM termekek t WHERE k.id = t.kategoria) as hasznalva  
    FROM `kategoriak` k WHERE k.id = '$id'
    GROUP BY k.nev;";
    $result = mysqli_query($conn, $sqlDelSelect);
    $row = mysqli_fetch_assoc($result);
    if ($row['hasznalva'] > 0) {
        echo json_encode(array('success' => false, 'messages' => array("Ez a kategória használatban van " . $row['hasznalva'] . " terméknél")));
    }else{
        $sqlDelete = "DELETE FROM kategoriak WHERE id = '$id'";
        mysqli_query($conn, $sqlDelete);
        logAction($conn, "Törölte ezt a Kategóriát: " . $row['nev'] . ".", $_SESSION['user']);
        echo json_encode(array('success' => true, 'messages' => array("Törölted ezt a Kategóriát: " . $row['nev'])));
    }
}else{
    back();
}

function back()
{
    header('location: ../kategoriak.php');
    die();
}
