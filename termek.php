<?php
define('ACCESS_ALLOWED', true);
require_once 'query/conn.php';
$url = explode("/", $_SERVER['REQUEST_URI']);
if (empty($url[3])) {
    header('location: /bolt');
}

$db = new dataBase();
$termek = $db->Select("SELECT * FROM bolt WHERE id = '$url[3]';");
if (empty($termek)) {
    header('location: /bolt');
}
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
<html lang="hu">
<?php
require_once "parts/head.php";
?>
<link rel="stylesheet" type="text/css" href="/css/swiper_termek.css">
</head>
<body>
<?php
require_once "parts/navbar.php";
?>

<main class="container">
    <div class="row row-cols-1 row-cols-sm-1 row-cols-lg-2 gx-4 gy-2 py-5 me-0 ">
        <div class="col">
            <div class="card card-termek p-2">
                <div class="swiper swiper-main">
                    <div class="swiper-wrapper">
                        <?php
                        foreach ($kepek as $key => $val) {
                            echo '<div class="swiper-slide "><img class="img-fluid zoom" src="/media/products/' . $val . '"></div>';
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
        <div class="col p-0">
            <div class="card card-termek">
                <div class="card-header">
                    <?php
                    //  var_dump($termek);
                    echo '<h4 class="fw-bold">' . $termek['nev'] . '</h4>' .
                        '<h4 >' . $price . '</h4>';
                    ?>
                </div>
                <div class="card-body">
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

                    ?>
                </div>
                <div class="card-footer">
                    <button type="button" class="btn btn-primary align-self-center w-100 my-2 p-2"
                            data-bs-toggle="tooltip" data-bs-placement="top"
                            data-bs-custom-class="custom-tooltip"
                            data-bs-title="A terméket a boltban tudjuk csak oda adni. Előzetes eggyeztetéshez írj emailt a scootercityshop@gmail.com email címen vagy a +36-70/650-8555 telefonszámon keresztül lehetséges">
                        Termék vásárlása
                    </button>
                </div>
            </div>
        </div>

    </div>
    <?php
    if ($tul != null) {
        ?>
        <section id="specifikaciok " class="mb-5 bg-card border border-1">
            <span class="fs-2 ps-2">Specifikációk</span>
            <div class="row row-cols-md-2 row-cols-1 gx-0 border mt-2">
                <?php
                foreach ($tul as $id => $arr) {
                    foreach ($arr as $key => $value) {
                        echo '<div class="fs-5 col ps-2 border">' . $key . ': ' . $value . '</div>';
                    }
                }
                ?>
            </div>
        </section>
        <?php
    }
    ?>
</main>
<section class="container-md mb-5">
    <div class="m-3 discover-title">
        <a class="fs-4 discover-link mb-3" href="bolt/new">Legújabb termékeink</a>
    </div>
    <div class="swiper nSwiper ">
        <div class="swiper-wrapper" id="newest">

        </div>
        <div class="swiper-button-next ns-next"></div>
        <div class="swiper-button-prev ns-prev"></div>
    </div>

</section>

<section>
    <div class="modal fade" id="zoomModal">
        <div class="modal-dialog modal-dialog-centered modal-xl">
            <div class="modal-content">
                <div class="modal-body text-center">
                    <button type="button" class="btn-close zoomClose m-3 fs-4" data-bs-dismiss="modal" aria-label="Close"></button>
                    <img class="img-fluid w-75" id="zoomIMG">
                </div>
            </div>
        </div>
    </div>
</section>

<?php
require_once "parts/footer.php";
?>
</body>

</html>


<!--termekek ebbol a kategoriabol-->