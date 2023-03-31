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
$keresett = explode('?',$keresett,2)[0];
$kereses = false;
if (isset($_GET['keyword']));
if (isset($_GET['sort'])){
    $sort = $_GET['sort'];
    if ($sort=='pup')$sort= "ORDER BY ar ASC, nev ASC";
    else if ($sort=='pdown')$sort= "ORDER BY ar DESC, nev ASC";
    else if ($sort=='z-a')$sort = "ORDER BY nev DESC";
    else $sort = 'ORDER BY nev ASC';
}else{
    $sort = 'ORDER BY nev ASC';
}
if (isset($_GET['keyword'])  && $keresett == "kereses"){
    $keresett =$_GET['keyword'];
    $kereses = true;

}
//var_dump($url);
//var_dump($keresett);
$limit = 25;
?>

<div class="row row-cols-2 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 row-cols-xl-5 row-cols-xxl-6 mb-3 me-0">
    <?php
    if (!isset($db)){
        require_once 'query/conn.php';
        $db = new dataBase();
    }
    if ($kereses){
        $termekek = $db->Select("SELECT id,nev,ar,leiras,indeximg FROM bolt WHERE nev like '%$keresett%' $sort LIMIT $limit;");
    }
    else {
        $katcheck = $db->Select("SELECT alkategoriak_nev as kats FROM kat_view WHERE nev like '$keresett'");
        if ($katcheck == null)
            $keresett = '%%';
        if ($katcheck == null || $katcheck[0]['kats'] == null || $keresett == '%%') {
            $termekek = $db->Select("SELECT id,nev,ar,leiras,indeximg FROM bolt WHERE knev like '$keresett' $sort LIMIT $limit;");
        } else {
            $kats = '';
            foreach (explode(',', $katcheck[0]['kats']) as $k) {
                if ($kats != '') $kats .= ',';
                $kats .= $kat->subkats($k, $db);
            }
            $kats = str_replace(',', '\',\'', $kats);
            $termekek = $db->Select("SELECT id,nev,ar,leiras,indeximg FROM bolt WHERE knev in ('$kats') $sort LIMIT $limit;");
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
                      <div class="card-body">
                        <p class="card-title fw-bold" id="Param_Nev">' . $row['nev'] . '</p>
                      </div>
                      <div class="p-2">
                      <div class="d-flex align-items-center justify-content-between rounded-pill bg-price py-2">
                        <h5 class="mb-0 ms-3"><span>' . $price . '</span></h5>
                      </div>
                      </div>
                    
                  <a class="card_click" href="/bolt/termek/' . $row['id'] . '/' . $row['nev'] . '"></a>
                </div>
              </div>';
        }
    }
    ?>
</div>


