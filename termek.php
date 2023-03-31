<?php
require_once 'query/conn.php';
require_once 'query/kategoriak.php';
$url = explode("/", $_SERVER['REQUEST_URI']);
$db = new dataBase();
$kat = new kategoriak();
$termek = $db->Select("SELECT * FROM bolt WHERE id = '$url[3]';");
$termek = $termek[0];
$mennyisegek = $db->Select("SELECT * FROM menny_pivot_2 WHERE termek_id = '$url[3]';");
if ($mennyisegek != null) $mennyisegek = $mennyisegek[0];
//var_dump($mennyisegek);
$kepek = explode(",", $termek['images']);
if ($kepek[0] == null) {
    $kepek[0] = 'product-placeholder.png';
}
$tul = json_decode($termek['tulajdonsagok']);
$fmt = numfmt_create('hu-HU', NumberFormatter::CURRENCY);
$price = str_replace(',00', '', numfmt_format_currency($fmt, $termek['ar'], "HUF"));
?>
<!DOCTYPE html>
<html>
<?php
require_once "parts/head.php";
?>

<body>
<?php
require_once "parts/navbar.php";
?>
<div class="row me-0">
    <?php
    require_once 'parts/sidebar.php';
    ?>

    <main id="pageContent" class="col-xxl-10 col-xl-9 col-lg-9 ms-sm-auto pb-md-4 px-3">
        <div class="row row-cols-1 row-cols-sm-1 row-cols-lg-2 gx-4 gy-2 my-2 me-0 ">
            <div class="col">
                <div class="card p-2">
                    <div style="--swiper-navigation-color: #fff; --swiper-pagination-color: #fff"
                         class="swiper swiper-main">
                        <div class="swiper-wrapper">
                            <?php
                            foreach ($kepek as $key => $val) {
                                echo '<div class="swiper-slide"><img class="img-fluid" src="/media/products/' . $val . '"></div>';
                            }
                            ?>
                        </div>
                        <div class="swiper-button-next"></div>
                        <div class="swiper-button-prev"></div>
                    </div>
                    <div class="swiper swiper-thumb mt-2">
                        <div class="swiper-wrapper">
                            <?php
                            foreach ($kepek as $key => $val) {
                                echo '<div class="swiper-slide"><img src="/media/products/' . $val . '"></div>';
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card card-termek p-3">
                    <?php
                    //  var_dump($termek);
                    echo '<h4 class="fw-bold">' . $termek['nev'] . '</h4>' .
                        '<h4 >' . $price . '</h4>';
                    ?>
                    <hr>
                    <h4>Méretek:</h4>
                    <?php
                    //                        var_dump(count($mennyisegek));
                    //                        var_dump(array_keys($mennyisegek));
                    $keys = array_keys($mennyisegek);
                    if ($mennyisegek != null) {
                        echo '<div>';
                        for ($i = 1; $i < count($mennyisegek); $i++) {
                            $menny = $mennyisegek[$keys[$i]];
                            if ($menny != null) {
                                echo '<span class="h5">' . $keys[$i] . ': ';
                                if ($menny > 2)
                                    echo '<img class="storage-img" src="/media/products/termek_ok.png"> ';
                                else if ($menny > 0) echo '<img class="storage-img" src="/media/products/termek_some.png">';
                                else echo '<img class="storage-img" src="/media/products/termek_cancel.png">';
                                echo '</span>';
                            }
                        }
                        echo '</div>';
                    } else {
                        echo '<span class="h5">Nincs raktáron<img class="storage-img" src="/media/products/termek_cancel.png"></span>';
                    }
                    echo '<h4>Leírás:</h4><p class="fs-5">' . $termek['leiras'] . '</p>';
                    if ($tul != null) {
                        foreach ($tul as $id => $arr) {
                            foreach ($arr as $key => $value) {
                                echo '<span class="fs-5">' . $key . ': ' . $value . '</span>';
                            }
                        }
                    }
                    ?>
                    <button type="button" class="btn btn-primary mt-3 align-self-center w-75"
                            data-bs-toggle="tooltip" data-bs-placement="top"
                            data-bs-custom-class="custom-tooltip"
                            data-bs-title="A terméket a boltban tudjuk csak oda adni. Előzetes eggyeztetéshez írj emailt a info@scootercity.hu email címen vagy a +36-30-273-9402 telefonszámon keresztül lehetséges">
                        Termék vásárlása
                    </button>
                </div>
            </div>
        </div>
    </main>
</div>
<?php
require_once "parts/footer.php";
?>
</body>

</html>