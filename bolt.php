<?php
define('ACCESS_ALLOWED', true);
require_once 'query/conn.php';
$url = explode("/", urldecode($_SERVER['REQUEST_URI']));
$db = new dataBase();
if (!isset($url[2])) $keresett = '%%';
else $keresett = $url[2];

if (empty($_GET['page'])) {
?>
<!DOCTYPE html>
<html lang="hu">
<?php
require_once 'parts/head.php';
?>
</head>
<body>
<?php
include_once "parts/navbar.php";
?>
<!-- sidebar -->
<div class="row me-0">
    <nav id="sidebar" class="col-xxl-2 col-xl-3 col-lg-3 d-md-block pe-0 offcanvas-lg offcanvas-start bg-sidebar2 "
         tabindex="-1">
        <div class="offcanvas-body d-block pt-1">
            <ul class="list-unstyled ps-0 w-100">

                <li class="mb-1 p-2">
                    <label class="fw-bold ms-2">Rendezés</label>
                    <select id="sort" class="form-select form-select-sm ">
                        <option value="">a-z sorrendben</option>
                        <option value="z-a">z-a sorrendben</option>
                        <option value="pup">ár szerint növekvő</option>
                        <option value="pdown">ár szerint csökkenő</option>
                    </select>
                </li>
                <div id="markak">

                </div>
                <div id="categories">

                </div>
            </ul>
        </div>
    </nav>
    <!-- sidebar end -->

    <!-- termekek -->
    <main class="col-xxl-10 col-xl-9 col-lg-9 ms-sm-auto pb-md-4 px-3">
        <div id="pageContent"
             class="row row-cols-2 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 row-cols-xl-5 row-cols-xxl-6 mb-3 me-0">
            <?php
            }
            ?>
        </div>
        <div class="w-100 text-center">
            <button class="space-btn w-50 justify-content-center" id="loadButton" onclick="loadMoreItem()">Több termék</button>
        </div>
    </main>
    <?php
    if (empty($_GET['page'])) {
    ?>
</div>
<?php
require_once 'parts/footer.php';
}
?>
</body>

</html>