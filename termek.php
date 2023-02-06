<?php
require_once 'query/conn.php';
$url = explode("/",$_SERVER['REQUEST_URI']);
?>
<!DOCTYPE html>
<html>
<?php
require_once "parts/head.php";
?>
<body>
<?php
require_once "parts/navbar.php";
require_once "parts/footer.php";
?>
</body>
</html>