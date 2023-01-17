<?php
if(isset($_POST['table'])){
    require 'conn.php';

    if($_POST['table'] == 'termekek'){    
        $sql = "SELECT t.*,k.nev as knev FROM `termekek` t 
        INNER JOIN `kategoriak` k ON k.id = t.kategoria 
        GROUP BY t.nev; ";
        $result = mysqli_query($conn, $sql);
    }
    else if($_POST['table'] == 'logs'){
        $sql = "SELECT * FROM logs";
        $result = mysqli_query($conn,$sql);
    }
    else if($_POST['table'] == 'fiokok'){
        $sql = "SELECT * FROM admin_users";
        $result = mysqli_query($conn, $sql);
    }
    else if($_POST['table'] == 'kategoriak'){
        $sql = "SELECT k.*, (SELECT COUNT(t.nev) FROM termekek t WHERE k.id = t.kategoria) as hasznalva  
        FROM `kategoriak` k
        GROUP BY k.nev;";
        $result = mysqli_query($conn, $sql);
    }

    $array = array();
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_array($result, 1)) {
            array_push($array, $row);
        }
    }
    echo json_encode($array,JSON_UNESCAPED_UNICODE,512);
}else{
    header('Location: ' ."http://".$_SERVER['HTTP_HOST']. '/scootercity/admin/login.php');
    die();
}
?>
