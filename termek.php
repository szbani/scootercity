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
<div class="row">
    <?php
    require_once 'parts/sidebar.php';
    ?>

    <main id="pageContent" class="col-md-9 ms-sm-auto col-lg-10 px-md-4 pb-md-4">
        <div class="container">
            <div class="row row-cols-1 row-cols-sm-1 row-cols-lg-2 g-2 my-2">
                <div class="col">
                    <div class="card p-3">
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
                        echo '<h5>' . $termek['nev'] . '</h5>' .
                            '<h5 class="fw-bold">' . $price . '</h5>';
                        ?>
                        <hr>
                        <?php
                        //                        var_dump(count($mennyisegek));
                        //                        var_dump(array_keys($mennyisegek));
                        $keys = array_keys($mennyisegek);
                        if ($mennyisegek != null) {
                            for ($i = 1; $i < count($mennyisegek); $i++) {
                                $menny = $mennyisegek[$keys[$i]];
                                if ($menny != null) {
                                    echo $keys[$i] . ': ';
                                    echo $menny . ' ';
                                }
                            }
                        } else {
                            echo '<p>Nincs raktáron<img src="/media/products/termek_cancel.png"></p>';
                        }

                        //                        if ($termek['mennyiseg'] > 3) {
                        //                            echo '<p>Raktáron<img src="/media/products/termek_ok.png"></p>';
                        //                        } else if ($termek['mennyiseg'] > 0) {
                        //                            echo '<p>Pár darab raktáron<img src="/media/products/termek_some.png"></p>';
                        //                        }
                        echo '<h6>Leírás:</h6><p>' . $termek['leiras'] . '</p>';
                        if ($tul != null) {
                            foreach ($tul as $id => $arr) {
                                foreach ($arr as $key => $value) {
                                    echo '<span>' . $key . ': ' . $value . '</span>';
                                }
                            }
                        }
                        ?>
                    </div>
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