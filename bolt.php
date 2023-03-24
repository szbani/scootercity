<?php
require_once 'query/conn.php';
require_once 'query/kategoriak.php';
$url = explode("/", urldecode($_SERVER['REQUEST_URI']));
$db = new dataBase();
$kat = new kategoriak();
$fmt = numfmt_create('hu-HU', NumberFormatter::CURRENCY);
if (!isset($url[2])) $keresett = '%%';
else $keresett = $url[2];

//var_dump($keresett);

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
    <div class="row">
    <?php
    include_once 'parts/sidebar.php';
    ?>
    <!-- sidebar end -->

    <!-- termekek -->
    <main id="pageContent" class="col-md-9 ms-sm-auto col-lg-10 px-md-4 pb-md-4">
    <?php
}
include 'itemload.php';
?>

    <!--row end-->
    <!--    <div id="termek_modal"></div>-->
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

<?php




?>