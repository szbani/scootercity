<?php
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    exit;
}
define('ACCESS_ALLOWED', true);
require_once "conn.php";
require_once 'login.php';

$errors = array();

if (!isset($_POST['delete'])) {
    if (isset($_POST['nev'])) {
        $inputNev = mysqli_real_escape_string($conn, $_POST['nev']);
        if (empty($inputNev)) {
            array_push($errors, "Hiányzik a márka neve!");
        }
        if (!empty($inputNev)) {
            $check = "SELECT id FROM marka WHERE nev = '$inputNev'";
            $result = mysqli_query($conn, $check);
            if (mysqli_num_rows($result) > 1) {
                array_push($errors, "A márka már fel van véve!");
            }
        }
        if ($_FILES['img']['name'] != '') {
            $errors = uploadImages($inputNev);
            $inputFileImg = "'" . $inputNev . '-' . $_FILES['img']['name'] . "'";
        } else $inputFileImg = 'NULL';
        if (count($errors) != 0) {
            array_push($errors, "Sikertelen Művelet");
            $_SESSION['errors'] = json_encode($errors);
            back();
        }
    } else back();
}

if (isset($_POST['upload'])) {
    $sqlUpload = "INSERT INTO marka(nev,img)
                    VALUES('$inputNev',$inputFileImg)";
    mysqli_query($conn, $sqlUpload);

    logAction($conn, "Felvette ezt a márkát: " . $inputNev . ".", $_SESSION['user']);
    $_SESSION['success'] = 'Sikeres márka Felvétel';
    back();
} else if (isset($_POST['edit'])) {
    $inputId = mysqli_real_escape_string($conn, $_POST['id']);

    $sqlSelectKategoria = "SELECT * , (SELECT COUNT(t.nev) FROM termekek t WHERE m.id = t.kategoria) as hasznalva 
    FROM marka m WHERE id = '$inputId'";
    $result = mysqli_query($conn, $sqlSelectKategoria);
    $oldMarka = mysqli_fetch_assoc($result);
    $file = '';
    if ($inputFileImg != 'NULL') {
        unlink("../../media/main/" . $oldMarka['img']);
        $file = ", img = $inputFileImg ";
    }
    $sqlUpdate = "UPDATE marka 
                SET nev = '$inputNev'$file WHERE id = '$inputId';";
    mysqli_query($conn, $sqlUpdate);
    var_dump($sqlUpdate);
    logAction($conn, "Szerkesztette ezt a márkát: (" . $inputId . ")" . $oldMarka['nev'] . " -> " . $inputNev . ".", $_SESSION['user']);
    $_SESSION['success'] = 'Sikeres Szerkesztés';
    back();
} else if (isset($_POST['delete'])) {
    $id  = $_POST['id'];
    $sqlDelSelect = "SELECT m.*, 
	(SELECT COUNT(t.nev) FROM termekek t WHERE m.id = t.marka) as hasznalva
    FROM `marka` m WHERE m.id = '$id' GROUP BY nev;";
    $result = mysqli_query($conn, $sqlDelSelect);
    $row = mysqli_fetch_assoc($result);
    if ($row['hasznalva'] > 0) {
        echo json_encode(array('success' => false, 'messages' => array("Ez a márka használatban van " . $row['hasznalva'] . " terméknél")));
    }else {
        if ($row['img'] != NULL) unlink("../../media/main/" . $row['img']);
        $sqlDelete = "DELETE FROM marka WHERE id = '$id'";
        mysqli_query($conn, $sqlDelete);
        logAction($conn, "Törölte ezt a márkát: " . $row['nev'] . ".", $_SESSION['user']);
        echo json_encode(array('success' => true, 'messages' => array("Törölted ezt a márkát: " . $row['nev'])));
    }
} else {
    back();
}

function uploadImages($inputNev)
{
    $errors = array();
    $allowTypes = array('jpg', 'png', 'jpeg');

    //termek id lekeres eleje
    $filename = $inputNev . '-M' . $_FILES['img']['name'];
    $target_dir = '../../media/main/' . $filename;

    $fileType = pathinfo($target_dir, PATHINFO_EXTENSION);
    $upload = true;
    if ($_FILES['img']["size"] > 10000000) {
        array_push($errors,  "A kép túl nagy méretű!");
        $upload = false;
    }
    if (!in_array($fileType, $allowTypes)) {
        array_push($errors, "Nem megfelelő fájl típus('$filename')");
        $upload = false;
    }
    if ($upload) {
        if (move_uploaded_file($_FILES['img']['tmp_name'], $target_dir)) {
        } else {
            array_push($errors, 'Sikertelen kép feltöltés(' . $filename . ')');
        }
    }

    return $errors;
}

function back()
{
    header('location: ../markak.php');
    die();
}


// SELECT k.*,
// 	(SELECT COUNT(t.nev) FROM termekek t WHERE k.id = t.kategoria) as hasznalva,
// 	(SELECT GROUP_CONCAT(id) FROM kategoriak k2 WHERE k2.subkat = k.id) AS alkategoriak
//     FROM `kategoriak` k GROUP BY nev;

