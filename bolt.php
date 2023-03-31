<?php
require_once 'query/conn.php';
require_once 'query/kategoriak.php';
$url = explode("/", urldecode($_SERVER['REQUEST_URI']));
$db = new dataBase();
$kat = new kategoriak();
$fmt = numfmt_create('hu-HU', NumberFormatter::CURRENCY);
if (!isset($url[2])) $keresett = '%%';
else $keresett = $url[2];

if (empty($_GET['page'])) {
?>
<!DOCTYPE html>
<html>
<?php
require_once 'parts/head.php';
?>

<body>
<?php
include_once "parts/navbar.php";
?>
<!-- sidebar -->
<div class="row me-0">
    <?php
    include_once 'parts/sidebar.php';
    ?>
    <!-- sidebar end -->

    <!-- termekek -->
    <main id="pageContent" class="col-xxl-10 col-xl-9 col-lg-9 ms-sm-auto pb-md-4 px-3">
        <?php
        }
        include 'itemload.php';
        ?>

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