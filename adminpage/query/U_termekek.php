<?php
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
    $inputMarka = mysqli_real_escape_string($conn,$_POST['marka']);
    if ($inputMarka == "")$inputMarka='NULL';
    $inputKategoria = mysqli_real_escape_string($conn, $_POST['kategoria']);
    $inputLeiras = '';
    if (isset($_POST['leiras'])) $inputLeiras = mysqli_real_escape_string($conn, $_POST['leiras']);

    //termek feltoltese
    $sqlTermek = "INSERT INTO termekek(nev,ar,leiras,kategoria,marka)
                    VALUES('$inputNev','$inputAr','$inputLeiras','$inputKategoria',$inputMarka);";
    $sqlGetId = "SELECT id FROM termekek WHERE nev = '$inputNev';";
    var_dump($sqlTermek);
    mysqli_query($conn, $sqlTermek);
    $result = mysqli_query($conn, $sqlGetId);
    $row = mysqli_fetch_assoc($result);
    $id = $row['id'];
    uploadTulajdonsagok($conn, $id);
    if (isset($_POST['menny-nev'])) {
        uploadMennyiseg($conn, $id);
    }
    // var_dump($sqlTulajdonsagok);

    //file feltoltes 
    $errors = uploadImages($conn, $id);

    logAction($conn, "Létrehozta ezt a terméket: " . $inputNev . ".", $_SESSION['user']);
    if ($errors != null) {
        $_SESSION['errors'] = json_encode($errors);
    }
    $_SESSION['success'] = 'Sikeres Termék Felvétel';
    back();
} else if (isset($_POST['edit'])) {
    $inputId = mysqli_real_escape_string($conn, $_POST['id']);
    $inputNev = mysqli_real_escape_string($conn, $_POST['nev']);
    $inputAr = mysqli_real_escape_string($conn, $_POST['ar']);
    $inputKategoria = mysqli_real_escape_string($conn, $_POST['kategoria']);
    $inputMarka = mysqli_real_escape_string($conn,$_POST['marka']);
    if ($inputMarka == "")$inputMarka='NULL';
    $inputLeiras = '';
    if (isset($_POST['leiras'])) $inputLeiras = mysqli_real_escape_string($conn, $_POST['leiras']);

    //termek update
    $sqlTermek = "UPDATE termekek
                    SET nev = '$inputNev',ar = '$inputAr',leiras='$inputLeiras',kategoria='$inputKategoria',marka=$inputMarka
                    WHERE id = '$inputId'";
    mysqli_query($conn, $sqlTermek);

    uploadTulajdonsagok($conn, $inputId);
    if (isset($_POST['menny-nev'])) {
        uploadMennyiseg($conn, $inputId);
    }
    //képek feltöltése
    $errors = uploadImages($conn, $inputId);

    logAction($conn, "Módosította ezt a számú terméket: " . $inputId . ".", $_SESSION['user']);
    if ($errors != null) {
        $_SESSION['errors'] = json_encode($errors);
    }
    $_SESSION['success'] = 'Sikeres Módosítás';
    back();
} else if (isset($_POST['delete'])) {
    $id = $_POST['id'];
    $nev = $_POST['nev'];

    $sqlDelteImages = "SELECT file_name FROM kepek WHERE termek_id = '$id';";
    $result = mysqli_query($conn, $sqlDelteImages);
    if (mysqli_num_rows($result)) {
        while ($row = mysqli_fetch_assoc($result)) {
            unlink("../../media/products/" . $row['file_name']);
        }
    }

    $sql = "DELETE FROM termekek WHERE id = '$id';";
    mysqli_query($conn, $sql);
    logAction($conn, "Törölte ezt a terméket: " . $nev . ". (".$id.")", $_SESSION['user']);
    echo json_encode(array('success' => true, 'messages' => array('Törölted (' . $id . ')' . $nev . ' nevű terméket.')));
    // } else if (isset($_POST['mennyId'])) {
    //     $id = $_POST['mennyId'];
    //     $mennyiseg = $_POST['mennyiseg'];
    //     $sql = "UPDATE termekek SET mennyiseg = '$mennyiseg' WHERE id = '$id';";
    //     mysqli_query($conn, $sql);
    //     echo "$mennyiseg";
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
    $sql = "DELETE FROM kepek WHERE file_name = '$name';";
    mysqli_query($conn, $sql);
    unlink("../" . $_POST['image']);
    echo json_encode(array('success' => true, 'messages' => array('Törölted a képet')));
} else {
    back();
}

function uploadTulajdonsagok($conn, $id)
{
    $values = '';
    for ($i = 0; $i < count($_POST['tul-nev']); $i++) {
        $tulNev = $_POST['tul-nev'][$i];
        if (!empty($tulNev)) {
            if ($values != null) $values .= ',';
            $tulNev = mysqli_real_escape_string($conn, $tulNev);
            $tulErtek = $_POST['tul-ertek'][$i];
            if (!empty($tulErtek)) {
                $tulErtek = mysqli_real_escape_string($conn, $tulErtek);
            } else {
                $tulErtek = 'Nincs adat';
            }
            $values .= "('$id','$tulNev','$tulErtek')";
        }
    }
    if ($values != '') {
        $sqlDeleteTuls = "DELETE FROM termek_tul WHERE termek_id = '$id'";
        mysqli_query($conn, $sqlDeleteTuls);
        $sqlTulajdonsagok = "INSERT INTO termek_tul(termek_id,tul_nev,tul_ertek)
                        VALUES $values;";
        mysqli_query($conn, $sqlTulajdonsagok);
    }
}

function uploadMennyiseg($conn, $id)
{

    $values = '';
    $meretek = array();
    for ($i = 0; $i < count($_POST['menny-nev']); $i++) {
        $mennyNev = $_POST['menny-nev'][$i];
        if (!empty($mennyNev)) {
            array_push($meretek, $mennyNev);
            if ($values != null) $values .= ',';
            $mennyNev = mysqli_real_escape_string($conn, $mennyNev);
            $mennyErtek = $_POST['menny-ertek'][$i];
            if (!empty($mennyErtek)) {
                $mennyErtek = mysqli_real_escape_string($conn, $mennyErtek);
            } else {
                $mennyErtek = 0;
            }
            $values .= "('$id','$mennyNev','$mennyErtek')";
        }
    }

    if (count($meretek) > 0) {
        $meretek2 = array();
        $sqlSelectMenny = "SELECT meret FROM termek_menny GROUP BY meret";
        $result = mysqli_query($conn, $sqlSelectMenny);
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                array_push($meretek2, $row['meret']);
            }
        }
        $alter = false;
        foreach ($meretek as $meret) {
            if (!in_array($meret, $meretek2)) {
                $alter = true;
                break;
            }
        }
        if ($alter) {
            $alterView = 'ALTER VIEW menny_pivot AS(SELECT tm.*,';
            $temp = '';
            $temp2 = '';
            foreach ($meretek2 as $meret) {
                if ($temp != '') $temp .= ',';
                $temp .= ' CASE WHEN tm.meret = "' . $meret . '" THEN tm.mennyiseg END AS ' . $meret;
                if ($temp2 != '') $temp2 .= ',';
                $temp2 .= "SUM($meret) AS $meret ";
            }
            $alterView .= $temp;
            foreach ($meretek as $meret) {
                if (!in_array($meret, $meretek2)) {
                    $alterView .= ', CASE WHEN tm.meret = "' . $meret . '" THEN tm.mennyiseg END AS ' . $meret;
                    $temp2 .= ", SUM($meret) AS $meret ";
                }
            }
            $alterView .= ' FROM `termek_menny` tm);';
            mysqli_query($conn, $alterView);
            $alterView2 = "ALTER VIEW menny_pivot_2 AS(SELECT termek_id, $temp2 FROM menny_pivot GROUP BY termek_id)";
            mysqli_query($conn, $alterView2);
        }
    }

    if ($values != '') {
        $sqlDeleteMenny = "DELETE FROM termek_menny WHERE termek_id = '$id'";
        mysqli_query($conn, $sqlDeleteMenny);
        $sqlMenny = "INSERT INTO termek_menny(termek_id,meret,mennyiseg)
                        VALUES $values;";
        mysqli_query($conn, $sqlMenny);
    }

}

function uploadImages($conn, $inputId)
{
    $errors = array();
    $allowTypes = array('jpg', 'png', 'jpeg');
    if ($_FILES['images']) {

        //termek id lekeres eleje
        //termek id lekeres vege
        $count = 1;
        if (isset($_POST['edit'])) {
            $sql = "SELECT MAX(img_order) AS max FROM `kepek` WHERE termek_id = $inputId";
            $result = mysqli_query($conn, $sql);
            $result = mysqli_fetch_assoc($result);
            if (($max = $result['max']) != null) {
                $count = $max + 1;
            }
        }

        $file_ary = array_filter($_FILES['images']['name']);
        foreach ($file_ary as $key => $val) {
            $filename = $inputId . '_' . basename($file_ary[$key]);
            $target_dir = '../../media/products/' . $filename;

            $fileType = pathinfo($target_dir, PATHINFO_EXTENSION);
            $upload = true;
            if (file_exists($target_dir)) {
                array_push($errors, basename($file_ary[$key]) . " nevű fájl már létezik ennél a terméknél!");
                $upload = false;
            }
            if ($_FILES['images']["size"][$key] > 10000000) {
                array_push($errors, basename($file_ary[$key]) . " fájl túl nagy méretű!");
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
                            VALUES('$inputId','$filename','$count')";
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
