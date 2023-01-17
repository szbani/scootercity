<?php
session_start();
require_once "conn.php";
require_once 'login.php';

$errors = array();

if (!isset($_POST['delete'])) {
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
        array_push($errors, "Sikertelen Művelet");
        $_SESSION['errors'] = $errors;
        back();
    }
}
// var_dump($_FILES);

if (isset($_POST['upload'])) {

    $inputNev = mysqli_real_escape_string($conn, $_POST['nev']);
    $inputAr = mysqli_real_escape_string($conn, $_POST['ar']);
    $inputKategoria = mysqli_real_escape_string($conn, $_POST['kategoria']);
    $inputMennyiseg = 0;
    if (isset($_POST['mennyiseg'])) $inputMennyiseg = mysqli_real_escape_string($conn, $_POST['mennyiseg']);
    $inputLeiras = '';
    if (isset($_POST['leiras'])) $inputLeiras = mysqli_real_escape_string($conn, $_POST['leiras']);
    $kepekSzama = 0;
    if ($_FILES['images']) {
        $file_ary = reArrayFiles($_FILES['images']);
        $kepekSzama = count($file_ary);
    }
    $inputTulajdonsagok = json_encode(arrayTulajdonsagok($conn), JSON_UNESCAPED_UNICODE, 512);

    //termek feltoltese
    $sqlTermek = "INSERT INTO termekek(nev,ar,leiras,kategoria,tulajdonsagok,mennyiseg,szkepek)
                    Values('$inputNev','$inputAr','$inputLeiras','$inputKategoria','$inputTulajdonsagok','$inputMennyiseg','$kepekSzama')";
    mysqli_query($conn, $sqlTermek);

    //file feltoltes 
    uploadImages($conn, $inputNev, $file_ary);

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
    $kepekSzama = 0;
    if ($_FILES['images']) {
        $file_ary = reArrayFiles($_FILES['images']);
        $kepekSzama = count($file_ary);
    }
    $inputTulajdonsagok = json_encode(arrayTulajdonsagok($conn), JSON_UNESCAPED_UNICODE, 512);

    //regi termek
    $sqlSelectTermek = "SELECT * FROM termekek where id = '$inputId'";
    $result = mysqli_query($conn, $sqlSelectTermek);
    $oldTermek = mysqli_fetch_assoc($result);

    //termek update
    $sqlTermek = "UPDATE termekek
                    SET nev = '$inputNev',ar = '$inputAr',leiras='$inputLeiras',kategoria='$inputKategoria',
                    tulajdonsagok='$inputTulajdonsagok',mennyiseg ='$inputMennyiseg',szkepek='$kepekSzama'
                    WHERE id = '$inputId'";
    mysqli_query($conn, $sqlTermek);

    //kepek törlése
    if ($oldTermek['szkepek'] > $kepekSzama) {
        for ($i = 0; $i < $oldTermek['szkepek']; $i++) {
            unlink('../../media/products/' . $inputId . '-' . $i.'.jpg');
        }
    }

    //képek feltöltése
    uploadImages($conn, $inputNev, $file_ary);
    

    logAction($conn, "Módosította ezt a számú terméket: " . $id . ".", $_SESSION['user']);
    $_SESSION['success'] = 'Sikeres Módosítás';
    back();
} else if (isset($_POST['delete'])) {
    $id = $_POST['id'];
    $sql = "SELECT nev,szkepek FROM termekek where id = '$id'";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    if ($row['szkepek'] > 0) {
        for ($i = 0; $i < $row['szkepek']; $i++)
            unlink('../../media/products/' . $id . '-' . $i.'.jpg');
    }
    $sql = "DELETE FROM termekek WHERE id = '$id'";
    mysqli_query($conn, $sql);
    logAction($conn, "Törölte ezt a terméket: " . $row['nev'] . ".", $_SESSION['user']);
    $_SESSION['success'] = 'Sikeres törlés';
    back();
}
back();

function reArrayFiles(&$file_post)
{
    $file_ary = array();
    $file_count = count($file_post['name']);
    $file_keys = array_keys($file_post);

    for ($i = 0; $i < $file_count; $i++) {
        foreach ($file_keys as $key) {
            $file_ary[$i][$key] = $file_post[$key][$i];
        }
    }

    return $file_ary;
}

function arrayTulajdonsagok($conn)
{
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

function uploadImages($conn, $inputNev, $file_ary)
{
    if ($_FILES['images']) {
        //termek id lekeres eleje
        $sqlSelectTermekId = "SELECT id FROM termekek WHERE nev = '$inputNev'";
        $result = mysqli_query($conn, $sqlSelectTermekId);
        $row = mysqli_fetch_assoc($result);
        $termekId = $row['id'];
        //termek id lekeres vege

        $target_dir = '../../media/products/';
        $i = 0;
        $insertValues = '';
        foreach ($file_ary as $file) {
            $file['name'] = $termekId . '-' . $i . '.jpg';
            $target_file = $target_dir . basename($file['name']);

            if (move_uploaded_file($file["tmp_name"], $target_file)) {
            } else {
                array_push($errors, 'Nem sikerült a képek feltöltése');
                back();
            }
            $i++;
        }
    }
}

function back()
{
    header('location: ../termekek.php');
    die();
}
