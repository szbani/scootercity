<?php
session_start();
require_once "conn.php";
require_once 'login.php';

$errors = array();

if (!isset($_POST['delete'])) {
    if (isset($_POST['nev'])) {
        $inputNev = mysqli_real_escape_string($conn, $_POST['nev']);
        if (empty($inputNev)) {
            array_push($errors, "Hiányzik a kategória neve!");
        }
        if (!empty($inputNev)) {
            $check = "SELECT id FROM kategoriak WHERE nev = '$inputNev'";
            $result = mysqli_query($conn, $check);
            if (mysqli_num_rows($result) > 1) {
                array_push($errors, "A kategória már létezik!");
            }
        }
        if ($_POST['inputSubKat'] != 'NULL') {
            if (isset($_POST['id']) && $_POST['id'] == $_POST['inputSubKat']) array_push($errors, 'Nem lehet önmagának az alkategóriája');
            $inputSubKat = "'" . mysqli_real_escape_string($conn, $_POST['inputSubKat']) . "'";
        } else $inputSubKat = 'NULL';
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
    $sqlUpload = "INSERT INTO kategoriak(nev,img,subkat)
                    VALUES('$inputNev',$inputFileImg,$inputSubKat)";
    var_dump($sqlUpload);
    mysqli_query($conn, $sqlUpload);

    logAction($conn, "Létrehozta ezt a Kategóriát: " . $inputNev . ".", $_SESSION['user']);
    // $_SESSION['success'] = 'Sikeres Kategória Felvétel';
    back();
} else if (isset($_POST['edit'])) {
    $inputId = mysqli_real_escape_string($conn, $_POST['id']);

    $sqlSelectKategoria = "SELECT * FROM kategoriak WHERE id = '$inputId'";
    $result = mysqli_query($conn, $sqlSelectKategoria);
    $oldKategoria = mysqli_fetch_assoc($result);
    $file = '';
    if ($inputFileImg != 'NULL') {
        unlink("../../media/main/" . $oldKategoria['img']);
        $file = ", img = $inputFileImg ";
    }
    $sqlUpdate = "UPDATE kategoriak 
                SET nev = '$inputNev'$file, subkat = $inputSubKat WHERE id = '$inputId';";
    mysqli_query($conn, $sqlUpdate);
    var_dump($sqlUpdate);
    logAction($conn, "Szerkesztette ezt a Kategóriát: (" . $inputId . ")" . $oldKategoria['nev'] . " -> " . $inputNev . ".", $_SESSION['user']);
    $_SESSION['success'] = 'Sikeres Szerkesztés';
    back();
} else if (isset($_POST['delete'])) {
    $id  = $_POST['id'];
    $sqlDelSelect = "SELECT k.*, 
	(SELECT COUNT(t.nev) FROM termekek t WHERE k.id = t.kategoria) as hasznalva,
	(SELECT GROUP_CONCAT(id) FROM kategoriak k2 WHERE k2.subkat = k.id) AS alkategoriak
    FROM `kategoriak` k WHERE k.id = '$id' GROUP BY nev;";
    $result = mysqli_query($conn, $sqlDelSelect);
    $row = mysqli_fetch_assoc($result);
    if ($row['hasznalva'] > 0) {
        echo json_encode(array('success' => false, 'messages' => array("Ez a kategória használatban van " . $row['hasznalva'] . " terméknél")));
    } else if ($row['alkategoriak'] != NULL) {
        echo json_encode(array('success' => false, 'messages' => array("Ez a kategória tartalmaz alkategóriákat, ezért nem lehet törölni")));
    } else {
        if ($row['img'] != NULL) unlink("../../media/main/" . $row['img']);
        $sqlDelete = "DELETE FROM kategoriak WHERE id = '$id'";
        mysqli_query($conn, $sqlDelete);
        // logAction($conn, "Törölte ezt a Kategóriát: " . $row['nev'] . ".", $_SESSION['user']);
        echo json_encode(array('success' => true, 'messages' => array("Törölted ezt a Kategóriát: " . $row['nev'])));
    }
} else {
    back();
}

function uploadImages($inputNev)
{
    $errors = array();
    $allowTypes = array('jpg', 'png', 'jpeg');

    //termek id lekeres eleje
    $filename = $inputNev . '-' . $_FILES['img']['name'];
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
    header('location: ../kategoriak.php');
    die();
}


// SELECT k.*, 
// 	(SELECT COUNT(t.nev) FROM termekek t WHERE k.id = t.kategoria) as hasznalva,
// 	(SELECT GROUP_CONCAT(id) FROM kategoriak k2 WHERE k2.subkat = k.id) AS alkategoriak
//     FROM `kategoriak` k GROUP BY nev;


// todo 
// ha van mar termek a kategoriahoz akkor ne egedjen subkatot hozza rendelni
// ha subkat a akategoria akkor ne egedjen termeket felvenni hozza