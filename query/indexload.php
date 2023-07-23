<?php

if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
    $where = '';
    if (isset($_GET['where'])){
        $where = $_GET['where'];
    }
    $limit = 10;
    if (isset($_GET['limit'])){
        $limit = $_GET['limit'];
    }

    if (!isset($db)) {
        define('ACCESS_ALLOWED', true);
        require_once 'conn.php';
        $db = new dataBase();
    }

    $select = $db->Select("SELECT id,nev,ar,indeximg,learazas FROM bolt WHERE $where limit $limit;");

    if (count($select) > 0) {
        echo(json_encode($select));
    }
}
