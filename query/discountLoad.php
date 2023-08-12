<?php
if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
    define('ACCESS_ALLOWED', true);
    require_once 'conn.php';
    $db = new dataBase();

    if (!empty($_GET['keyword'])) {
        $result = $db->Select("SELECT count(id) as count FROM bolt where learazas is not null AND  nev like '%" . $_GET['keyword'] . "%'");
    }else if (!empty($_GET['kat'])) {
        $kat = $_GET['kat'];
        $result = $db->Select("SELECT count(id) as count FROM bolt where learazas is not null AND knev like '$kat'");
    }
    else if(empty($_GET['kat'])){
        $result = $db->Select("SELECT count(id) as count FROM bolt where learazas is not null");
    }
    else{
        echo '';
    }
    echo $result[0]['count'];
} else {
    header("HTTP/1.1 403 Forbidden");
    exit("Access restricted");
}
