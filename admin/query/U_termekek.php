<?php
session_start();
require_once "conn.php";
require_once 'login.php';

$errors = array();

if (isset($_POST['upload']) || isset($_POST['edit'])) {
    if (empty($_POST['nev'])) {
        array_push($errors, "Hiányzik a termék neve!");
    }
    if (empty($_POST['ar'])) {
        array_push($errors, "Hiányzik a termék ára!");
    } else if (!is_numeric($_POST['ar'])) {
        array_push($errors, "Az ár betűket is tartalmaz!");
    }
    if (empty($_POST['kategoria'])) {
        array_push($errors, "Hiányzik a termék kategóriája!");
    }

    if (count($errors) != 0) {
        $_SESSION['errors'] = json_encode($errors);
        back();
    }
}
// return var_dump($_POST);

if (isset($_POST['upload'])) {
    $inputNev = mysqli_real_escape_string($conn, $_POST['nev']);
    $inputAr = mysqli_real_escape_string($conn, $_POST['ar']);
    $inputKategoria = mysqli_real_escape_string($conn, $_POST['kategoria']);
    $inputMennyiseg = 0;
    if (isset($_POST['mennyiseg'])) $inputMennyiseg = mysqli_real_escape_string($conn, $_POST['mennyiseg']);
    $inputLeiras = '';
    if (isset($_POST['leiras'])) $inputLeiras = mysqli_real_escape_string($conn, $_POST['leiras']);

    $inputTulajdonsagok = json_encode(arrayTulajdonsagok($conn), JSON_UNESCAPED_UNICODE, 512);

    //termek feltoltese
    $sqlTermek = "INSERT INTO termekek(nev,ar,leiras,kategoria,tulajdonsagok,mennyiseg)
                    Values('$inputNev','$inputAr','$inputLeiras','$inputKategoria','$inputTulajdonsagok','$inputMennyiseg')";
    mysqli_query($conn, $sqlTermek);

    //file feltoltes 
    $errors = uploadImages($conn, $inputNev);

    logAction($conn, "Létrehozta ezt a terméket: " . $inputNev . ".", $_SESSION['user']);
    $_SESSION['success'] = 'Sikeres Termék Felvétel';
    back();
} else if (isset($_POST['edit'])) {
    $inputId = mysqli_real_escape_string($conn, $_POST['id']);
    $inputNev = mysqli_real_escape_string($conn, $_POST['nev']);
    $inputAr = mysqli_real_escape_string($conn, $_POST['ar']);
    $inputKategoria = mysqli_real_escape_string($conn, $_POST['kategoria']);
    $inputMennyiseg = 0;
    if (isset($_POST['mennyiseg'])) $inputMennyiseg = mysqli_real_escape_string($conn, $_POST['mennyiseg']);
    $inputLeiras = '';
    if (isset($_POST['leiras'])) $inputLeiras = mysqli_real_escape_string($conn, $_POST['leiras']);

    $inputTulajdonsagok = json_encode(arrayTulajdonsagok($conn), JSON_UNESCAPED_UNICODE, 512);

    //termek update
    $sqlTermek = "UPDATE termekek
                    SET nev = '$inputNev',ar = '$inputAr',leiras='$inputLeiras',kategoria='$inputKategoria',
                    tulajdonsagok='$inputTulajdonsagok',mennyiseg ='$inputMennyiseg'
                    WHERE id = '$inputId'";
    mysqli_query($conn, $sqlTermek);

    //képek feltöltése
    $errors = uploadImages($conn, $inputNev);

    logAction($conn, "Módosította ezt a számú terméket: " . $inputId . ".", $_SESSION['user']);
    if($errors != null){
        $_SESSION['errors'] = json_encode($errors);
    }
    $_SESSION['success'] = 'Sikeres Módosítás';
    back();
} else if (isset($_POST['delete'])) {
    $id = $_POST['id'];
    $nev = $_POST['nev'];

    $sqlDelteImages = "SELECT file_name FROM kepek WHERE termek_id = '$id';";
    $result = mysqli_query($conn,$sqlDelteImages);
    if(mysqli_num_rows($result)){
        while($row = mysqli_fetch_assoc($result)){
            unlink("../../media/products/".$row['file_name']); 
        }
    }

    $sql = "DELETE FROM termekek WHERE id = '$id'";
    mysqli_query($conn, $sql);
    logAction($conn, "Törölte ezt a terméket: " . $nev . ".", $_SESSION['user']);
    echo json_encode(array('success' => true, 'messages' => array('Törölted (' . $id . ')' . $nev . ' nevű terméket.')));
} else if (isset($_POST['mennyId'])) {
    $id = $_POST['mennyId'];
    $mennyiseg = $_POST['mennyiseg'];
    $sql = "UPDATE termekek SET mennyiseg = '$mennyiseg' WHERE id = '$id';";
    mysqli_query($conn, $sql);
    echo "$mennyiseg";
} else if (isset($_POST['reorder'])) {
    $images = "";
    $names = "";
    foreach ($_POST['images'] as $key => $value) {
        if ($names != "") $names .= ",";
        $url = explode("/", $value);
        $name = $url[count($url) - 1];
        $images .= "WHEN '$name' THEN ' $key'";
        $names .= "'$name'";
    }
    $sql = "UPDATE kepek
    SET img_order 
    = CASE file_name
    $images
    ELSE img_order
    END
    WHERE file_name IN($names)";
    mysqli_query($conn, $sql);
} else if (isset($_POST['imgDelete'])) {
    $url = explode("/", $_POST['image']);
    $name = $url[count($url) - 1];
    $sql = "DELETE FROM kepek WHERE file_name = '$name'";
    mysqli_query($conn, $sql);
    unlink("../" . $_POST['image']);
    echo json_encode(array('success' => true, 'messages' => array('Törölted a képet')));
} else {
    back();
}

function arrayTulajdonsagok($conn){
    $tempTulajdonsagok = array();
    for ($i = 0; $i < count($_POST['tul-nev']); $i++) {
        $tulNev = $_POST['tul-nev'][$i];
        if (!empty($tulNev)) {
            $tulNev = mysqli_real_escape_string($conn, $tulNev);
            $tulErtek = $_POST['tul-ertek'][$i];
            if (!empty($tulErtek)) {
                $tulErtek = mysqli_real_escape_string($conn, $tulErtek);
            } else {
                $tulErtek = 'Nincs adat';
            }
            array_push($tempTulajdonsagok, [$tulNev => $tulErtek]);
        }
    }
    return $tempTulajdonsagok;
}

function uploadImages($conn, $inputNev){
    $errors = array();
    $allowTypes = array('jpg', 'png', 'jpeg');
    if ($_FILES['images']) {
        //termek id lekeres eleje
        $sqlSelectTermekId = "SELECT id FROM termekek WHERE nev = '$inputNev'";
        $result = mysqli_query($conn, $sqlSelectTermekId);
        $row = mysqli_fetch_assoc($result);
        $termekId = $row['id'];
        //termek id lekeres vege
        $count = 1;
        if (isset($_POST['edit'])) {
            $sql = "SELECT MAX(img_order) AS max FROM `kepek` WHERE termek_id = '$termekId'";
            $result = mysqli_query($conn, $sql);
            $max = mysqli_fetch_column($result);
            if ($max != null) {
                $count = $max + 1;
            }
        }

        $file_ary = array_filter($_FILES['images']['name']);
        foreach ($file_ary as $key => $val) {
            $filename = $termekId . '_' . basename($file_ary[$key]);
            $target_dir = '../../media/products/' . $filename;

            $fileType = pathinfo($target_dir, PATHINFO_EXTENSION);
            $upload = true;
            if (file_exists($target_dir)) {
                array_push($errors, basename($file_ary[$key]) . " nevű fájl már létezik ennél a terméknél!");
                $upload = false;
            }
            if ($_FILES['images']["size"][$key] > 10000000) {
                array_push($errors, basename($file_ary[$key]) . " fájl tól nagy méretű!");
                $upload = false;
            }
            if (!in_array($fileType, $allowTypes)) {
                array_push($errors, "Nem megfelelő fájl típus('$filename')");
                $upload = false;
            }
            if ($upload) {
                if (move_uploaded_file($_FILES['images']['tmp_name'][$key], $target_dir)) {
                    //mysql insert
                    $sql = "INSERT INTO kepek (termek_id,file_name,img_order)
                            VALUES('$termekId','$filename','$count')";
                    mysqli_query($conn, $sql);
                    $count++;
                } else {
                    array_push($errors, 'Sikertelen kép feltöltés(' . $filename . ')');
                }
            }
        }
    }
    return $errors;
}

function back()
{
    header('location: ../termekek.php');
    die();
}
