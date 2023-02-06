<?php
require_once 'query/conn.php';
$url = explode("/",$_SERVER['REQUEST_URI']);
$db = new dataBase();
$termek = $db->Select("SELECT t.*,k.nev as knev, (SELECT GROUP_CONCAT(file_name ORDER BY img_order) FROM kepek k WHERE k.termek_id = t.id) as images FROM `termekek` t 
INNER JOIN `kategoriak` k ON k.id = t.kategoria WHERE t.id = '$url[3]';");
$termek = $termek[0];
$tul = json_decode($termek['tulajdonsagok']);
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
    <div class="col-6">

    </div>
    <div class="col-6">
        <p><?php echo $termek['nev']?></p>
        <p><?php echo $termek['ar']?></p>
        <p><?php echo $termek['kategoria']?></p>
        <p><?php echo $termek['leiras']?></p>
        <?php
        // var_dump($url);
        var_dump($tul);echo'<br>';
         var_dump($termek);?>
    </div>
</div>
<?php
require_once "parts/footer.php";
?>
</body>
</html>