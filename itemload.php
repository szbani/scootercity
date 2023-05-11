<?php
//if (!empty($_GET['page'])) {
//    $page = trim($_GET['page']);
//    if (file_exists($page)) {
//        include('bolt.php');
//    } else {
//        include('404.php');
//    }
//} else {
//    echo "This anchor tage has no url";
//}
if (isset($_GET['page'])) $url = $_GET['page'];
$fmt = numfmt_create('hu-HU', NumberFormatter::CURRENCY);
if (!isset($url[2])) $keresett = '%%';
else $keresett = $url[2];
$keresett = explode('?', $keresett, 2)[0];
$kereses = false;
if (!empty($_GET['keyword'])) ;
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
    $brand = " AND marka IN ('".str_replace('|',  "','" , $brand)."')";
} else {
    $brand = '';
}
if (!empty($_GET['keyword']) && $keresett == "kereses") {
    $keresett = $_GET['keyword'];
    $kereses = true;

}
//var_dump($url);
//var_dump($keresett);
$limit = 25;
?>

<div class="row row-cols-2 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 row-cols-xl-5 row-cols-xxl-6 mb-3 me-0">
    <?php
    if (!isset($db)) {
        require_once 'query/conn.php';
        $db = new dataBase();
    }
    if ($kereses) {
        // Ha a keresés mezőből keresnek itemket.
        $termekek = $db->Select("SELECT id,nev,ar,leiras,indeximg FROM bolt WHERE nev like '%$keresett%' $brand $sort LIMIT $limit;");
    } else {
        // Megnézi hogy az adott kategóriában milyen alkategóriák vannak
        $katcheck = $db->Select("SELECT alkategoriak_nev as kats FROM kat_view WHERE nev like '$keresett'");
        if ($katcheck == null)
            // Ha nincs a keresett kategória akkor az összesere állitja
            $keresett = '%%';
        if ($katcheck == null || $katcheck[0]['kats'] == null || $keresett == '%%') {
            // Ha nincs kategoria akkor lekeri az osszes itemet
            $termekek = $db->Select("SELECT id,nev,ar,leiras,indeximg FROM bolt WHERE knev like '$keresett' $brand $sort LIMIT $limit;");
        } else {
            //megkeresi a kategoriakban levo kategoriakat es azokat keri le
            $kats = '';
            foreach (explode(',', $katcheck[0]['kats']) as $k) {
                if ($kats != '') $kats .= ',';
                $kats .= $kat->subkats($k, $db);
            }
            $kats = str_replace(',', '\',\'', $kats);
            $termekek = $db->Select("SELECT id,nev,ar,leiras,indeximg FROM bolt WHERE knev in ('$kats') $brand $sort LIMIT $limit;");
        }
    }
    if (count($termekek) > 0) {

        foreach ($termekek as $row) {
            $price = str_replace(',00', '', numfmt_format_currency($fmt, $row['ar'], "HUF"));
            $kep = $row['indeximg'];
            if ($row['indeximg'] == null) $kep = 'product-placeholder.png';
            echo '<div class="col mt-3">
                    <div class="card rounded shadow-sm">
                    <img src="/media/products/' . $kep . '" class="card-img-top align-self-center" alt="Termék">
                      <div class="text-over-image">
                          <div class="item-text px-2">
                            <p class="card-title fw-bold mb-0" id="Param_Nev">' . $row['nev'] . '</p>
                          </div>
                          
                            <div class="d-flex bg-price px-2">
                                <h5 class="mb-1 "><span>' . $price . '</span></h5>
                            </div>
                        </div>
                      <a class="card_click" href="/bolt/termek/' . $row['id'] . '/' . $row['nev'] . '"></a>
                    </div>
                  </div>';
        }
    }
    ?>
</div>


