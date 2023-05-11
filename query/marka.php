<?php
if (!isset($db)) {
    require_once 'conn.php';
    $db = new dataBase();
}
if (!isset($kat)) {
    require_once 'kategoriak.php';
    $kat = new kategoriak();
}
if (isset($_GET['page'])) $url = $_GET['page'];
if (!isset($url[2])) $keresett = '%%';
else $keresett = $url[2];
$keresett = explode('?', $keresett, 2)[0];
//var_dump($keresett);
$katcheck = $db->Select("SELECT alkategoriak_nev as kats FROM kat_view WHERE nev like '$keresett'");
if ($katcheck == null) $keresett = '%%';
if ($keresett != '%%') {
    $markakats = $kat->subkats($keresett, $db);
//    var_dump($markakats);
    $markakats = str_replace(',', '\',\'', $markakats);
    $markakat = "AND knev IN ('$markakats')";
//    var_dump($markakat);
} else {
    $markakat = "AND knev like '$keresett'";
}
if (!empty($_GET['keyword'])) {
    $markakat = "AND nev like '%" . $_GET['keyword'] . "%'";
}

$markak = $db->Select("SELECT marka as nev, COUNT(marka) as darab FROM bolt WHERE marka is not NULL " . $markakat . " GROUP BY marka ORDER BY nev ASC;");
//var_dump($markak);
if (!empty($markak)) {
    ?>
    <li class="mb-1 bg-sidebar2">

        <button class="btn btn-toggle d-inline-flex align-items-center rounded border-0 collapsed fw-bold w-100"
                data-bs-toggle="collapse" data-bs-target="#markaCollapse" aria-expanded="true">
            Márka
        </button>
        <div class="collapse show" id="markaCollapse">
            <?php
            foreach ($markak as $marka) {
                echo '<div class="form-check sidebar-item"><label  for="' . $marka['nev'] . '">' . $marka['nev'] . ' (' . $marka['darab'] . ') </label>
                                  <input class="form-check-input marka" value="' . $marka['nev'] . '" id="' . $marka['nev'] . '" type="checkbox"></div>';
            }
            ?>
        </div>
    </li>
    <?php
}
?>