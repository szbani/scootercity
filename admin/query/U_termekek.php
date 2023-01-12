<?php
session_start();
require_once "conn.php";
require_once 'login.php';

$errors = array();

if(!isset($_POST['delete'])){
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
        back();
    }
}
// var_dump($_FILES);

if (isset($_POST['upload'])) {

    $inputNev = mysqli_real_escape_string($conn, $_POST['nev']);
    $inputAr = mysqli_real_escape_string($conn, $_POST['ar']);
    $inputKategoria = mysqli_real_escape_string($conn, $_POST['kategoria']);
    $inputLeiras = '';
    if (isset($_POST['leiras'])) $inputLeiras = mysqli_real_escape_string($conn, $_POST['leiras']);

    //kell csinalnom egy keresest ami kiszuri a nemhasznalt a nemhasznalt FK kat es kitorli oket az editnel.
    //hozza kell adnom a termekekhez egy mennyiseg mezot.
    
    //tulajdonsagok json re alakitasa eleje
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
    $inputTulajdonsagok = json_encode($tempTulajdonsagok, JSON_UNESCAPED_UNICODE, 512);
    //tulajdonsagok json re alakitasa vege

    //termek feltoltese eleje
    $sqlTermek = "INSERT INTO termekek(nev,ar,leiras,kategoria,tulajdonsagok)
                    Values('$inputNev','$inputAr','$inputLeiras','$inputKategoria','$inputTulajdonsagok')";

    mysqli_query($conn, $sqlTermek);
    //termek feltoltese vege

    //termek id lekeres eleje
    $sqlSelectTermekId = "SELECT id FROM termekek WHERE nev = '$inputNev'";
    $result = mysqli_query($conn, $sqlSelectTermekId);
    $row = mysqli_fetch_assoc($result);
    $termekId = $row['id'];
    //termek id lekeres vege

    
    if ($_FILES['images']) {
        //file feltoltes eleje
        $file_ary = reArrayFiles($_FILES['images']);
        
        $target_dir = '../../media/products/';
        $i = 0;
        $insertValues = '';
        foreach ($file_ary as $file) {
            $file['name'] = $termekId . '-' . $i . '.jpg';
            $target_file = $target_dir . basename($file['name']);

            if (move_uploaded_file($file["tmp_name"], $target_file)) {
                echo "Sikeres fájl feltöltés " . htmlspecialchars(basename($file["name"])) . ".";
            } else {
                array_push($errors, 'Nem sikerült a képek feltöltése');
                back();
            }
            //file feltoltes vege

            //file adatb be toltes eleje
            $fileNev = $file['name'];
            $sqlKepId = "SELECT id FROM kepek WHERE kep = '$fileNev'";
            $result = mysqli_query($conn, $sqlKepId);
            
            if (mysqli_num_rows($result) == 0) {
                if (!empty($insertValues)) $insertValues .= ',';
                $insertValues .= "('$fileNev')";
            }
            $i++;
            //file adatb be toltes vege
        }
        if (!empty($insertValues)) {
            $sqlKepek = "INSERT INTO kepek(kep)VALUES" . $insertValues . ";";
            mysqli_query($conn, $sqlKepek);
        }
        
    }
    

    if ($_FILES['images']) {
        //kep id lekeres eleje
        $kepek = '';
        for ($i = 0; $i < count($file_ary); $i++) {
            $fileNev = $termekId . '-' . $i . '.jpg';
            if (!empty($kepek)) $kepek .= ',';
            $kepek .= "'" . $fileNev . "'";
        }
        $sqlSelectKepekId = "SELECT id FROM kepek 
                            WHERE kep IN ($kepek)";
        $result = mysqli_query($conn, $sqlSelectKepekId);
        //kep id lekeres vege

        //kepekFk feltoltese eleje
        $sorszam = 1;
        $kepekFkValues = '';
        while($row = mysqli_fetch_assoc($result)){
            $imageId = $row['id'];
            if(!empty($kepekFkValues)) $kepekFkValues .= ',';
            $kepekFkValues .= '('.$termekId.','.$imageId.','.$sorszam.')';
            $sorszam++;
        }
        $sqlKepekFk = "INSERT INTO kepek_fk(termid,kepid,sorrend)
                    VALUES $kepekFkValues";
        //kepekFk feltoltese vege
    } else {
        $sqlKepekFk = "INSERT INTO kepek_fk(termid,kepid,sorrend)
                    VALUES('$termekId','9','1')";
    }
    // var_dump($sqlKepekFk);
    mysqli_query($conn, $sqlKepekFk);
    logAction($conn, "Létrehozta ezt a terméket: " . $inputNev . ".", $_SESSION['user']);
    $_SESSION['success'] = 'Sikeres Termék Felvétel';
    back();
    // */

} else if (isset($_POST['edit'])) {
    //
} else if (isset($_POST['delete'])) {
    $id = $_POST['id'];
    $sql = "SELECT nev FROM termekek where id = '$id'";
    $result = mysqli_query($conn, $sql);
    $nev = mysqli_fetch_assoc($result);
    $sql = "DELETE FROM termekek where id = '$id'";
    mysqli_query($conn, $sql);
    logAction($conn, "Törölte ezt a terméket: " . $nev['nev'] . ".", $_SESSION['user']);
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


function back()
{
    header('location: ../termekek.php');
    die();
}
