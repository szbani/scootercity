<?php
if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
    define('ACCESS_ALLOWED', true);
    require_once 'conn.php';
    $db = new dataBase();
    $kats = $db->Select('SELECT id,nev,alkategoriak,hasznalva,subkat FROM kat_view where alkategoriak is not null or hasznalva > 0');
    echo json_encode($kats);

}else{
    header("HTTP/1.1 403 Forbidden");
    exit("Access restricted");
}


