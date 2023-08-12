<!DOCTYPE html>
<html lang="hu">
<?php
define('ACCESS_ALLOWED', true);
require_once 'query/conn.php';
$db = new dataBase();
require_once 'parts/head.php'; ?>
<link rel="stylesheet" type="text/css" href="/css/swiper_main.css">
</head>

<body>
<?php
include 'parts/navbar.php'
?>

<main class="bg-secondary">
    <section class="bg-main">
        <div class="main-text pb-5">
            <div class="text-center fs-4 fw-bold">
                <h1 class="display-1 fw-bold"><strong>scootercity motorosbolt</strong></h1>
            </div>
        </div>
    </section>
    <section class="container-md">
        <div class="m-3 discover-title">
            <a class="fs-4 mb-3 discover-link ps-1" href="bolt/learazott">Leárazott termékeink</a>
        </div>
        <div class="swiper dSwiper pb-5">
            <div class="swiper-wrapper" id="discounts"></div>
            <div class="swiper-button-next ds-next"></div>
            <div class="swiper-button-prev ds-prev"></div>
        </div>
    </section>
    <div class="divider-rotated"></div>
    <!--Kategoriak-->
    <section class="divider-between py-5">
        <div class="container">
            <div class="row row-cols-2 py-5">
                <?php
                $kategoriak = $db->Select('SELECT nev,img FROM kat_view where img is not null');
                foreach ($kategoriak as $kat) {
                    echo '
                <div class="col col-lg-4 col-md-4 card-margin">
                    <a href="/bolt/' . $kat['nev'] . '">
                        <div class="h-100 main-container">
                            <img src="/media/main/' . $kat['img'] . '" alt="">
                            <div class="overlay">
                                <div class="main-description text-center">
                                    <div class="title">
                                        ' . $kat['nev'] . '
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>';
                }
                ?>
            </div>
        </div>

    </section>
    <div class="divider-rotated"></div>
    <section class="text-center p-5 bg-white">
        <label class="fs-4 mb-3">Márkáink</label>

        <div class="swiper mSwiper ">
            <div class="swiper-wrapper">
                <?php
                $markak = $db->Select('SELECT nev,img FROM marka');
                foreach ($markak as $marka) {
                    echo '<div class="swiper-slide"><a href="/bolt?brand=' . $marka["nev"] . '"><img src="media/main/' . $marka['img'] . '"></a></div>';
                }
                ?>
            </div>
            <div class="swiper-pagination"></div>
        </div>
        <hr>
    </section>

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
</main>
</div>
<?php
require_once 'parts/footer.php';
?>
</body>

</html>