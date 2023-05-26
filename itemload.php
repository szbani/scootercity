<?php
if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {

    if (isset($_GET['page'])) $url = $_GET['page'];
    if (!isset($url[2])) $keresett = '%%';
    else $keresett = $url[2];
    $keresett = explode('?', $keresett, 2)[0];
    $kereses = false;

    if (!empty($_GET['sort'])) {
        $sort = $_GET['sort'];
        if ($sort == 'pup') $sort = "ORDER BY ar ASC, nev ASC";
        else if ($sort == 'pdown') $sort = "ORDER BY ar DESC, nev ASC";
        else if ($sort == 'z-a') $sort = "ORDER BY nev DESC";
        else $sort = 'ORDER BY nev ASC';
    } else {
        $sort = 'ORDER BY nev ASC';
    }
    if (!empty($_GET['brand'])) {
        $brand = $_GET['brand'];
        $brand = " AND marka IN ('" . str_replace('|', "','", $brand) . "')";
    } else {
        $brand = '';
    }
    if (!empty($_GET['keyword']) && $keresett == "kereses") {
        $keresett = $_GET['keyword'];
        $kereses = true;

    }
    if (!empty($_GET['pageNumber'])) $pageNumber = $_GET['pageNumber'];
    else $pageNumber = 0;
    if (!empty($_GET['limit'])) $limit = $_GET['limit'];
    else $limit = 10;
    $offset = $pageNumber * $limit;

    define('ACCESS_ALLOWED', true);
    if (!isset($db)) {
        require_once 'query/conn.php';
        $db = new dataBase();
    }
    if (!isset($kat)) {
        require_once 'query/kategoriak.php';
        $kat = new kategoriak();
    }
    if ($kereses) {
        // Ha a keresés mezőből keresnek itemket.
        $termekek = $db->Select("SELECT id,nev,ar,indeximg,learazas FROM bolt WHERE nev like '%$keresett%' $brand $sort LIMIT $offset , $limit;");
    } else {
        // Megnézi hogy az adott kategóriában milyen alkategóriák vannak
        $katcheck = $db->Select("SELECT alkategoriak_nev as kats FROM kat_view WHERE nev like '$keresett'");
        if ($katcheck == null)
            // Ha nincs a keresett kategória akkor az összesere állitja
            $keresett = '%%';
        if ($katcheck == null || $katcheck[0]['kats'] == null || $keresett == '%%') {
            // Ha nincs kategoria akkor lekeri az osszes itemet
            $termekek = $db->Select("SELECT id,nev,ar,indeximg,learazas FROM bolt WHERE knev like '$keresett' $brand $sort LIMIT $offset , $limit;");
        } else {
            //megkeresi a kategoriakban levo kategoriakat es azokat keri le
            $kats = '';
            foreach (explode(',', $katcheck[0]['kats']) as $k) {
                if ($kats != '') $kats .= ',';
                $kats .= $kat->subkats($k, $db);
            }
            $kats = str_replace(',', '\',\'', $kats);
            $termekek = $db->Select("SELECT id,nev,ar,indeximg,learazas FROM bolt WHERE knev in ('$kats') $brand $sort LIMIT $offset , $limit;");
        }
    }
    $arr = array();
    if (count($termekek) > 0) {
        echo(json_encode($termekek));
    }
}else{
    exit();
}





