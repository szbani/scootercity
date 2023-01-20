<?php
if (isset($_POST['table'])) {
    session_start();
    require 'conn.php';

    if ($_POST['table'] == 'termekek') {
        $sql = "SELECT t.*,k.nev as knev FROM `termekek` t 
        INNER JOIN `kategoriak` k ON k.id = t.kategoria 
        GROUP BY t.nev; ";
        $result = mysqli_query($conn, $sql);
    } else if ($_POST['table'] == 'logs') {
        $sql = "SELECT * FROM logs";
        $result = mysqli_query($conn, $sql);
    } else if ($_POST['table'] == 'fiokok') {
        $sql = "SELECT a.*, 
	    (SELECT CONCAT(l.action,' ',l.time) FROM logs l 
        WHERE l.action LIKE 'Bejelentkezett' AND l.user = a.email
        ORDER BY l.time DESC LIMIT 1) as action
        FROM `admin_users` a;";
        $result = mysqli_query($conn, $sql);
    } else if ($_POST['table'] == 'kategoriak') {
        $sql = "SELECT k.*, (SELECT COUNT(t.nev) FROM termekek t WHERE k.id = t.kategoria) as hasznalva  
        FROM `kategoriak` k
        GROUP BY k.nev;";
        $result = mysqli_query($conn, $sql);
    }

    $array = array();
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_array($result, 1)) {
            if ($_POST['table'] == 'fiokok') {
                $data = array();
                if ($_SESSION['main'] == 0 || $_SESSION['user'] == $row['email']) {
                    $data += ['edit' => '<i class="fa fa-pencil"/>'];
                } else $data += ['edit' => ""];
                if ($_SESSION['main'] == 0 && $_SESSION['user'] != $row['email']) {
                    $data += ['delete' => '<i class="fa fa-trash"/>'];
                } else $data += ['delete' => ""];
                array_push($array, array_merge($row, $data));
            } else {
                array_push($array, $row);
            }
        }
    }
    echo json_encode($array, JSON_UNESCAPED_UNICODE, 512);
} else {
    require "conn.php";
    session_start();
    $sql = "SELECT a.*, 
    (SELECT CONCAT(l.action,' ',l.time) FROM logs l 
    WHERE l.action LIKE 'Bejelentkezett' AND l.user = a.email
    ORDER BY l.time DESC LIMIT 1) as action
    FROM `admin_users` a;";
    $result = mysqli_query($conn, $sql);
    $array = array();
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_array($result, 1)) {
            $data = array();
            if ($_SESSION['main'] == 0 || $_SESSION['user'] == $row['email']) {
                $data += ['edit' => '<i class="fa fa-pencil"/>'];
            } else $data += ['edit' => ""];
            if ($_SESSION['main'] == 0 && $_SESSION['user'] == $row['email']) {
                $data += ['delete' => '<i class="fa fa-trash"/>'];
            } else $data += ['delete' => ""];
            array_push($array, array_merge($row, $data));
        }
    }
    var_dump($array);
    // header('Location: ' . "http://" . $_SERVER['HTTP_HOST'] . '/scootercity/admin/login.php');
    // die();
}
